console.log("accessing api with GET");

var xhttp;
var articleList;
xhttp = new XMLHttpRequest();

xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        console.log("received : " + this.responseText);
        articleList = JSON.parse(this.responseText);
        console.log(articleList);
        document.getElementById("lol").innerHTML = "Il y a " + articleList.length + " elements dans la base.";
    }
};

xhttp.open("GET", "http://api/php/api?action=get_list_articles", true);
xhttp.send();
