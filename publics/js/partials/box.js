
function switch_display(ons,tw,forme='block')
{
    var one = document.querySelector(ons);
    var two = document.querySelector(tw);
    one.style.display = 'none';
    two.style.display = forme;
}