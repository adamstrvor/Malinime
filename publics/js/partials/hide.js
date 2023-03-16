var counter=0;
function hide(hid,sho,inp)
{
    var hide = document.querySelector('#'+hid);
    var show = document.querySelector('#'+sho);
    var input = document.querySelector('#'+inp);

    if(counter == 0)
    {
        hide.style.display = 'none';
        show.style.display = 'inline';
        input.type = 'text';
        counter=1;
    }
    else
    {
        show.style.display = 'none';
        hide.style.display = 'inline';
        input.type = 'password';
        counter=0;
    }

}