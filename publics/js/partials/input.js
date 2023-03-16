
//-------------------------------------------

function profil_change(obj,text="")
{
    var input = document.querySelector(obj);
    var result = confirm(text);

    if(result == true)
    {
        input.click();
    }
}

//-------------------------------------------

function profil_changed(obj,img)
{
    var profil = document.querySelector(img);

    if('files' in obj)
    {
        if(obj.files.length == 0)
        {
            alert("Please retry, an error occur");
        }
        else
        {
            var fReader = new FileReader();
            fReader.readAsDataURL(obj.files[0]);
            fReader.onloadend = function(event){
                profil.src = event.target.result;
            }
        }
    }

}

//-------------------------------------------

function profil_upload(obj,state,img,chang=null)
{
    var state = document.querySelector(state);
    var profil = document.querySelector(img);
    if(chang != null)
    {
        var change = document.querySelector(chang);
    }
    // var allChild = obj.parentNode.childNodes;
    // for(i in allChild)
    // {
    //     if(allChild[i].tagName == 'img')
    //     {
    //         var profil = allChild[i];
    //         alert(JSON.stringify(allChild[i]));
    //         break;
    //     }
    // }

    if('files' in obj)
    {
        if(obj.files.length == 0)
        {
            state.style.display = 'block';
            state.innerHTML = 'Selectionner un fichier';
        }
        else
        {
            var fReader = new FileReader();
            fReader.readAsDataURL(obj.files[0]);
            fReader.onloadend = function(event){
                profil.src = event.target.result;
            }
            state.style.display = 'none';
            change.style.display = 'block';
        }
    }
    else
    {
        if(obj.value == "")
        {
            state.style.display = 'block';
            state.innerHTML = 'Selectionner un fichier';
        }
        else
        {
            state.style.display = 'block';
            state.innerHTML = '<span > Cet fichier n\'est pas prise en charge par votre navigateur !<br><br>Selectionner un autre fichier </span>';
        }
    }
}

//-------------------------------------------

function profil(obj)
{
    var input = document.querySelector(obj);
    input.click();
    // var allChild = obj.parentNode.childNodes;
    // for(i in allChild)
    // {
    //     if(allChild[i].type == 'file')
    //     {
    //         allChild[i].click();
    //         break;
    //     }
    // }
}

//-------------------------------------------

function input_text(obj,output=null,display='block')
{
    var correct = false;
    var outp = null;
    if(output != null)
    {
        var outp = document.querySelector(output);
    }

    if(obj.value == "")
    {
        obj.setAttribute('class','bad');
        if(outp != null)
        {
            outp.style.display = display ;
            outp.innerHTML = 'Champ vide !';
        }
        correct = false;
    }
    else
    {
        // var valid = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',' ','0','1','2','3','4','5','6','7','8','9','@','é','à','è','ê','â','î','û','ô','ç','+','-',')','(','*','!','=','.',',','ˆ','`','´','©','®','≈','˚','≤','≥','≠','/','\\','“','”','÷','&','%','?','∆','…','«','»'];

        // var val = (obj.value.toLowerCase()).split("");
        // var test=0;
        // for(i in val){ for(y in valid){ if(valid[y] == val[i]){ test++; } } }

        // if(test == (val.join("")).length )
        // {
            obj.setAttribute('class','good');
            if(outp != null)
            {
                outp.style.display = 'none';
            }
            correct = true;
        // }
        // else
        // {
        //     obj.setAttribute('class','bad');
        //     if(outp != null)
        //     {
        //         outp.style.display = display ;
        //         outp.innerHTML = 'Saisie invalid !';
        //     }
        //     correct = false;
        // }
    }

    return correct;
}

//-------------------------------------------

function input_text_area(obj,output=null,display='block')
{
    var correct = false;
    var outp = null;
    if(output != null)
    {
        var outp = document.querySelector(output);
    }

    if(obj.value == "")
    {
        obj.setAttribute('class','bad');
        if(outp != null)
        {
            outp.style.display = display ;
            outp.innerHTML = 'Champ vide !';
        }
        correct = false;
    }
    else
    {
        // var valid = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',' ','0','1','2','3','4','5','6','7','8','9','@','é','à','è','ê','â','î','û','ü','ô','ç','+','-',')','(','*','!','=','.',',','ˆ','`','´','©','®','≈','˚','≤','≥','≠','/','\\','“','”','÷','&','%','?','∆','…','«','»',"'",';','|','\"','\n'];

        // var val = (obj.value.toLowerCase()).split("");
        // var test=0;
        // for(i in val){ for(y in valid){ if(valid[y] == val[i]){ test++; } } }

        // if(test == (val.join("")).length )
        // {
            obj.setAttribute('class','good');
            if(outp != null)
            {
                outp.style.display = 'none';
            }
            correct = true;
        // }
        // else
        // {
        //     obj.setAttribute('class','bad');
        //     if(outp != null)
        //     {
        //         outp.style.display = display ;
        //         outp.innerHTML = 'Saisie invalid !';
        //     }
        //     correct = false;
        // }
    }

    return correct;
}

//-------------------------------------------

function input_email(obj,output=null,display='block')
{
    var correct = false;
    var outp = null;
    if(output != null)
    {
        var outp = document.querySelector(output);
    }

    if(obj.value == "")
    {
        correct = false;
        obj.setAttribute('class','bad');
        if(outp != null)
        {
            outp.style.display = display ;
            outp.innerHTML = 'Champ vide !';
        }
    }
    else
    {
        // var valid = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','0','1','2','3','4','5','6','7','8','9','@','.','_'];

        // var val = (obj.value.toLowerCase()).split("");
        // var test=0;
        // for(i in val){ for(y in valid){ if(valid[y] == val[i]){ test++; } } }

        // if(test == (val.join("")).length)
        // {
            obj.setAttribute('class','good');
            if(outp != null)
            {
                outp.style.display = 'none';
            }
            correct = true;
        // }
        // else
        // {
        //     obj.setAttribute('class','bad');
        //     if(outp != null)
        //     {
        //         outp.style.display = display ;
        //         outp.innerHTML = 'Email invalid !';
        //     }
        //     correct = false;
        // }
    }
    return correct;
}

//-------------------------------------------

function input_password(obj,output=null,display='block')
{
    var correct = false;
    var outp = null;
    if(output != null)
    {
        var outp = document.querySelector(output);
    }

    if(obj.value == "")
    {
        correct = false;
        obj.setAttribute('class','bad');
        if(outp != null)
        {
            outp.style.display = display ;
            outp.innerHTML = 'Champ vide !';
        }
    }
    else
    {
        // var valid = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',' ','0','1','2','3','4','5','6','7','8','9','@','$','&','.','_','#'];

        // var val = (obj.value.toLowerCase()).split("");
        // var test=0;
        // for(i in val){ for(y in valid){ if(valid[y] == val[i]){ test++; } } }

        // if(test == (val.join("")).length )
        // {
            obj.setAttribute('class','good');
            if(outp != null)
            {
                outp.style.display = 'none';
            }
            correct = true;
        // }
        // else
        // {
        //     obj.setAttribute('class','bad');
        //     if(outp != null)
        //     {
        //         outp.style.display = display ;
        //         outp.innerHTML = 'Mot de passe invalid !';
        //     }
        //     correct = false;
        // }
    }
    return correct;
}


//-------------------------------------------

function input_number(obj,output=null,display='block')
{
    var correct = false;
    var outp = null;
    if(output != null)
    {
        var outp = document.querySelector(output);
    }

    if(obj.value == "")
    {
        correct = false;
        obj.setAttribute('class','bad');
        if(outp != null)
        {
            outp.style.display = display ;
            outp.innerHTML = 'Champ vide !';
        }
    }
    else
    {
        // var valid = ['0','1','2','3','4','5','6','7','8','9','.',',',' '];

        // var val = (obj.value.toLowerCase()).split("");
        // var test=0;
        // for(i in val){ for(y in valid){ if(valid[y] == val[i]){ test++; } } }

        // var nb = parseFloat(val.join(""));

        // if(test == (val.join("")).length && nb >=0 )
        // {
            obj.setAttribute('class','good');
            if(outp != null)
            {
                outp.style.display = 'none';
            }
            correct = true;
        // }
        // else
        // {
        //     obj.setAttribute('class','bad');
        //     if(outp != null)
        //     {
        //         outp.style.display = display ;
        //         outp.innerHTML = 'Nombre invalid !';
        //     }
        //     correct = false;
        // }
    }
    return correct;
}

//-------------------------------------------

function input_phone(obj,output=null,display='block')
{
    var correct = false;
    var outp = null;
    if(output != null)
    {
        var outp = document.querySelector(output);
    }

    if(obj.value == "")
    {
        correct = false;
        obj.setAttribute('class','bad');
        if(outp != null)
        {
            outp.style.display = display ;
            outp.innerHTML = 'Champ vide !';
        }
    }
    else
    {
        // var valid = ['0','1','2','3','4','5','6','7','8','9',' ','+'];

        // var val = (obj.value.toLowerCase()).split("");
        // var test=0;
        // for(i in val){ for(y in valid){ if(valid[y] == val[i]){ test++; } } }

        // if(test == (val.join("")).length )
        // {
            obj.setAttribute('class','good');
            if(outp != null)
            {
                outp.style.display = 'none';
            }
            correct = true;
        // }
        // else
        // {
        //     obj.setAttribute('class','bad');
        //     if(outp != null)
        //     {
        //         outp.style.display = display ;
        //         outp.innerHTML = 'Numero de téléphone invalid !';
        //     }
        //     correct = false;
        // }
    }
    return correct;
}

//-------------------------------------------

function input_range(obj,output=null)
{
    if(output != null)
    {
        var outp = document.querySelector(output);
        outp.innerHTML = obj.value;
    }
}