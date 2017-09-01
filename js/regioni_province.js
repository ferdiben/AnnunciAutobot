var regione = new Object()

regione["Abruzzo"] = [{value: "1", text: "L'Aquila"},
    {value: "2", text: "Chieti"},
    {value: "3", text: "Pescara"},
    {value: "4", text: "Teramo"}];

regione["Basilicata"] = [{value: "1", text: "Potenza"},
{value: "2", text: "Matera"}];


regione["Calabria"] = [{value: "1", text: "Reggio Calabria"},
    {value: "2", text: "Catanzaro"},
    {value: "3", text: "Crotone"},
    {value: "4", text: "Vibo Valentia Marina"},
    {value: "5", text: "Cosenza"}];

regione["Campania"] = [{value: "1", text: "Napoli"},
    {value: "2", text: "Avellino"},
    {value: "3", text: "Caserta"},
    {value: "4", text: "Benevento"},
    {value: "5", text: "Salerno"}];

regione["Emilia Romagna"] = [{value: "1", text: "Bologna"},
    {value: "2", text: "Reggio Emilia"},
    {value: "3", text: "Parma"},
    {value: "4", text: "Modena"},
    {value: "5", text: "Ferrara"},
    {value: "6", text: "Forli Cesena"},
    {value: "7", text: "Piacenza"},
    {value: "8", text: "Ravenna"},
    {value: "9", text: "Rimini"}];

regione["Friuli Venezia Giulia"] = [{value: "1", text: "Trieste"},
    {value: "2", text: "Gorizia"},
    {value: "3", text: "Pordenone"},
    {value: "4", text: "Udine"}];

regione["Lazio"] = [{value: "1", text: "Roma"},
    {value: "2", text: "Latina"},
    {value: "3", text: "Frosinone"},
    {value: "4", text: "Viterbo"},
    {value: "5", text: "Rieti"}];

regione["Liguria"] = [{value: "1", text: "Genova"},
    {value: "2", text: "Imperia"},
    {value: "3", text: "La Spezia"},
    {value: "4", text: "Savona"}];

regione["Lombardia"] = [{value: "1", text: "Milano"},
    {value: "2", text: "Bergamo"},
    {value: "3", text: "Brescia"},
    {value: "4", text: "Como"},
    {value: "5", text: "Cremona"},
    {value: "6", text: "Mantova"},
    {value: "7", text: "Monza e Brianza"},
    {value: "8", text: "Pavia"},
    {value: "9", text: "Sondrio"},
    {value: "10", text: "Lodi"},
    {value: "11", text: "lecco"},
    {value: "11", text: "Varese"}];

regione["Marche"] = [{value: "1", text: "Ancona"},
    {value: "2", text: "Ascoli Piceno"},
    {value: "3", text: "Fermo"},
    {value: "4", text: "Macerata"},
    {value: "5", text: "Pesaro Urbino"}];

regione["Molise"] = [{value: "1", text: "Campobasso"},
    {value: "2", text: "Isernia"}];


regione["Piemonte"] = [{value: "1", text: "Torino"},
    {value: "2", text: "Vercelli"},
    {value: "3", text: "Novara"},
    {value: "4", text: "Cunco"},
    {value: "5", text: "Asti"},
    {value: "6", text: "Alessandria"},
    {value: "7", text: "Biella"},
    {value: "8", text: "Verbania"}];


regione["Valle D'Aosta"] = [{value: "1", text: "Aosta"}];

regione["Puglia"] = [{value: "1", text: "Bari"},
    {value: "2", text: "Barletta-Andria-Trani"},
    {value: "3", text: "Brindisi"},
    {value: "4", text: "Foggia"},
    {value: "5", text: "Lecce"},
    {value: "6", text: "Taranto"}, ];

regione["Sardegna"] = [{value: "1", text: "Cagliari"},
    {value: "2", text: "Sassari"},
    {value: "3", text: "Nuoro"},
    {value: "4", text: "Oristano"},
    {value: "5", text: "Carbonia Iglesias"},
    {value: "6", text: "Medio Campidano"},
    {value: "7", text: "Olbia Tempio"},
    {value: "8", text: "Ogliastra"}];

regione["Sicilia"] = [{value: "1", text: "Palermo"},
    {value: "2", text: "Agrigento"},
    {value: "3", text: "Caltanisetta"},
    {value: "4", text: "Catania"},
    {value: "5", text: "Enna"},
    {value: "6", text: "Messina"},
    {value: "7", text: "Ragusa"},
    {value: "8", text: "Siracusa"},
    {value: "9", text: "Trapani"}];

regione["Toscana"] = [{value: "1", text: "Arezzo"},
    {value: "2", text: "Massa Carrara"},
    {value: "3", text: "Firenze"},
    {value: "4", text: "Livorno"},
    {value: "5", text: "Grosseto"},
    {value: "6", text: "Lucca"},
    {value: "7", text: "Pisa"},
    {value: "8", text: "Pistoia"},
    {value: "9", text: "Prato"},
    {value: "10", text: "Siena"}];

regione["Trentino Alto Adige"] = [{value: "1", text: "Bolzano"},
    {value: "2", text: "Trento"}];

regione["Umbria"] = [{value: "1", text: "Perugia"},
    {value: "2", text: "Trapani"}];

regione["Veneto"] = [{value: "1", text: "Venezia"},
    {value: "2", text: "Belluno"},
    {value: "3", text: "Padova"},
    {value: "4", text: "Rovigo"},
    {value: "5", text: "Treviso"},
    {value: "6", text: "Verona"},
    {value: "6", text: "Vicenza"}];

function setProvincia(chooser) {
    var newElem;
    var provChooser = chooser.form.elements["provincia"];
    while (provChooser.options.length) {
        provChooser.remove(0);
    }
    var choice = chooser.options[chooser.selectedIndex].value;
    var db = regione[choice];
    newElem = document.createElement("option");
    newElem.text = "Seleziona una provincia:";
    newElem.value = "";
    provChooser.add(newElem);
    if (choice != "") {
        for (var i = 0; i < db.length; i++) {
            newElem = document.createElement("option");
            newElem.text = db[i].text;
            newElem.value = db[i].value;
            provChooser.add(newElem);
        }
    }
}

function setTextField2(provincia) {
    document.getElementById('provinciatxt').value = provincia.options[provincia.selectedIndex].text;
}