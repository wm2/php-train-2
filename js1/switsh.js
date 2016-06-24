/**
 * Created by user on 14.04.16.
 */
var s;
var raven = prompt("Сколько на ветке ворон?","1 - 10");
raven = parseInt(raven);
if (raven < 11 && raven > 0){
switch (raven){
        case 0: s = "На ветке 0 ворон";break;
        case 1: s = "На ветке 1 ворона";break;
        case 2: s = "На ветке 2 вороны";break;
        case 3: s = "На ветке 3 вороны";break;
        case 4: s = "На ветке 4 вороны";break;
        case 5: s = "На ветке 5 ворон";break;
        case 6: s = "На ветке 6 ворон";break;
        case 7: s = "На ветке 7 ворон";break;
        case 8: s = "На ветке 8 ворон";break;
        case 9: s = "На ветке 9 ворон";break;
        case 10: s = "На ветке 10 ворон";break;
}
}
else
{
   s = "На ветке не может сидеть больше 10 ворон !!!";
}

document.write("<h4>"+ s + "</h4>");