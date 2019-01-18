$("#budgetMode").click(function()
{
    $("#mode").val('Budget');
    $("#modeButton").html("Budget <span class=\"caret\"></span>");
});
$("#einnahmenMode").click(function()
{
    $("#mode").val('Einnahmen');
    $("#modeButton").html("Einnahmen <span class=\"caret\"></span>");
});
$("#ausgabenMode").click(function()
{
    $("#mode").val('Ausgaben');
    $("#modeButton").html("Ausgaben <span class=\"caret\"></span>");
});
$("#year").click(function()
{
    $("#timeSpan").val('Dieses Jahr');
    $("#timeSpanButton").html("Dieses Jahr <span class=\"caret\"></span>");
});
$("#month").click(function()
{
    $("#timSpan").val('Diesen Monat');
    $("#timeSpanButton").html("Diesen Monat <span class=\"caret\"></span>");
});
$("#week").click(function()
{
    $("#timeSpan").val('Diese Woche');
    $("#timeSpanButton").html("Diese Woche <span class=\"caret\"></span>");
});
$("#own").click(function()
{
    $("#timeSpan").val('Eigen');
    $("#timeSpanButton").html("Eigen <span class=\"caret\"></span>");
});