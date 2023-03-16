//-------------------------------


function open_waiting(){
    var waitingg = document.querySelector(".GLOBAL_WAITING");
    waitingg.style.opacity = 1;
    waitingg.style.top = 0;
    waitingg.style.height = "100%";
    waitingg.style.width = "100%";
    waitingg.style.display = 'flex';
};

function close_waiting(){
    var waitingg = document.querySelector(".GLOBAL_WAITING");
    waitingg.style.opacity = 0;
    waitingg.style.top = '-1000px';
    waitingg.style.height = "0";
    waitingg.style.width = "0";
    // waitingg.style.display = 'none';
};

//-------------------------------

function validate(obj)
{
    var childs = obj.childNodes;
    var ok = Array();

    for(i in childs)
    {
        if(childs[i].ctype == 'phone')
        ok[i] = input_phone(childs[i]);
        else if(childs[i].type == 'text')
        ok[i] = input_text(childs[i]);
        else if(childs[i].type == 'email')
        ok[i] = input_email(childs[i]);
        else if(childs[i].type == 'number')
        ok[i] = input_number(childs[i]);
        else if(childs[i].tagName == 'textarea')
        ok[i] = input_text_area(childs[i]);
        if(childs[i].type == 'password')
        ok[i] = input_password(childs[i]);
    }

    for(i in ok)
    {
        if(ok[i] == false)
        {
            alert("Saisissez correctement vos informations");
            return false;
        }
    }

    open_waiting();
    return true;
}