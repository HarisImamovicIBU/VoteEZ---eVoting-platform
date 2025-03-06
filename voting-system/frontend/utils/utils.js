var Utils = {
    init_spapp: () => {
        var app = $.spapp({
            templateDir: "./pages/",
            defaultView: "#register"
        });
        app.route({
            view: "register",
            load: "register.html"
        });
        app.route({
            view: "login",
            load: "login.html"
        });
        app.route({
            view: "home",
            load: "home.html"
        });
        app.route({
            view: "candidates",
            load: "candidates.html",
            onCreate: ()=>{
                Utils.fetchDataAndCreateDatatable();
            }
        });
        app.route({
            view: "vote",
            load: "vote.html",
            onCreate: ()=>{
                Utils.fetchDataAndCreateSelect2();
            }
        });
        app.route({
            view: "contact",
            load: "contact.html"
        });
        $(document).on("click", "a.nav-link", function () {
            setTimeout(()=>{
                window.scrollTo(0, 0);
            }, 1);
        });
        app.run();
    },
    fetchDataAndCreateDatatable: () => {
        $.ajax({
            url: "data/CANDIDATES.json",
            dataType: "json",
            success: (data) => {
                let tableBody = $("#candidatesTable tbody");
                tableBody.empty();
                let counter = 0;
                data.candidates.forEach((candidate) => {
                    let row = `<tr>
                                <td>${candidate.name}</td>
                                <td>${candidate.age}</td>
                                <td>${candidate.political_party}</td>
                                <td>${candidate.motto}</td>
                               </tr>`;
                    tableBody.append(row);
                });
                console.log(counter);
                if($.fn.DataTable.isDataTable("#candidatesTable")){
                    $("#candidatesTable").DataTable().clear().destroy();
                }
                $("#candidatesTable").DataTable();
            },
            error: (xhr, Status, error) => {
                console.error("Failed to load candidates:", error);
            }
        });
    },
    fetchDataAndCreateSelect2: ()=>{
        $.ajax({
            url: "data/CANDIDATES.json",
            dataType: "json",
            success: (data)=>{
                let selectParty = $("#partySelect");
                let selectCandidates = $("#candidateSelect");
                selectParty.empty();
                let uniqueParties = new Set();
                data.candidates.forEach((candidate)=>{
                    uniqueParties.add(candidate.political_party);
                });
                uniqueParties.forEach((party) => {
                    selectParty.append(`<option value="${party}">${party}</option>`);
                });
                $("#partySelect").on("change", function(e){
                    let selectedParty = $(this).val();
                    $("#toAdd").empty();
                    $("#toAdd").append(` from ${selectedParty}`);
                    selectCandidates.empty();
                    data.candidates.forEach((candidate)=>{
                        if(candidate.political_party===selectedParty){
                            selectCandidates.append(`<option value="${candidate.name}">${candidate.name}</option>`);
                        }
                    selectCandidates.select2();
                    });

                })
            }, 
            error: (xhr, Status, error)=>{
                console.error("Failed to load candidates: ", error);
            }
        });
    }
};