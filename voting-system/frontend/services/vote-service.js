var VoteService={
    init: function(){
        const token = localStorage.getItem("user_token");
        if(!token){
            return window.location.replace("index.html");
        }
        const user = Utils.parseJwt(token).user;
        if(!user || !user.role){
            return window.location.replace("index.html");
        }
        RestClient.get(`users/${user.id}`, function(userFromDb){
                if(userFromDb.has_voted==1){
                    $.blockUI({message:`<h3>Redirecting back to home page...</h3>`});
                    toastr.info("You have already voted once.");
                    setTimeout(() => {
                        $.unblockUI();
                        window.location.replace("index.html");
                    }, 2500);
                }else{
                    VoteService.voteProcess(user.id);
                }
            }, function(xhr, status, error){
                console.error("Error fetching the user: ", error);
            });
    },
    voteProcess: function(userId){
        RestClient.get("parties", function(parties){
            let selectParty = $("#partySelect");
            selectParty.empty();
            selectParty.append(`<option value="">Select a party</option>`);
            parties.forEach(party=>{
                selectParty.append(`<option value="${party.id}">${party.name}</option>`);
            });
        }, function(xhr, status, error){
            console.error("Error fetchin parties: ", error);
        });
        $("#partySelect").on("change", function(){
            const partyId = $(this).val();
            if(!partyId){
                return;
            }
            RestClient.get(`candidates/${partyId}`, function (candidates) {
                let candidateSelect = $("#candidateSelect");
                candidateSelect.empty();
                candidates.forEach(candidate=>{
                    candidateSelect.append(`<option value="${candidate.id}">${candidate.name}</option>`);
                });
                candidateSelect.select2({
                    maximumSelectionLength: 3,
                    placeholder: "Select up to 3 candidates",
                    width: '100%'
                });
            });
        });
        $("#submitVote").on("click", function() {
            const selectedParty = $("#partySelect").val();
            const selected = $("#candidateSelect").val() || [];
            if(!selectedParty){
                return toastr.error("Please select a political party!");
            }
            if(selected.length===0){
                return toastr.error("Please select at least one candidate!");
            }
            if(selected.length > 3){
                return toastr.error("Please select at most 3 candidates!");
            }
            $("#areYouSureModal").modal("show");
            $("#areYouSureModal .btn-danger").off("click").on("click", ()=>{
                $("#areYouSureModal").modal("hide");
                $.blockUI({message: "<h3>Processing your vote ...</h3>"});
                let posts=0;
                selected.forEach(candidateId=>{
                    RestClient.post("vote", {user_id: userId, candidate_id: candidateId},function(){
                        RestClient.patch(`candidate/${candidateId}`, {vote_count: 'increment'}, function(){
                            posts++;
                            if(posts === selected.length){
                                RestClient.patch(`user/${userId}`, {has_voted: 1}, function(){
                                    toastr.success("Your vote has been submitted!");
                                    setTimeout(()=>{
                                        $.blockUI({message: `<h3>Thank you for voting. You will now be logged out.</h3>`});
                                        setTimeout(()=>{
                                            localStorage.removeItem("user_token");
                                            UserService.logout();
                                            $.unblockUI();
                                        }, 2000)
                                    }, 2500);
                                }, function(xhr, status, error){
                                    console.error("Error: ", error);
                                    $.unblockUI();
                                });
                            }
                        }, function(xhr, status, error){
                            console.error("Error: ", error);
                        });
                    },function(xhr, status, error){
                        console.error("Error: ", error);
                    });
                });
            });
        });
    }
}