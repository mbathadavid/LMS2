function showtimer(timefield){
    var datetime = new Date();
    return document.getElementById(`${timefield}`).innerHTML = datetime;
}