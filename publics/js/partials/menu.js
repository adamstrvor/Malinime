//---------------------------------
function box_display(toDisplay,forme="block")
{
    var target = document.querySelector(toDisplay);
    if(target.style.display == "")target.style.display = "none";
    if(target.style.display === "none"){
    target.style.display = forme;
    }
    else{
    target.style.display = "none";
    }
    target.addEventListener('mouseleave',function(){
        target.style.display = 'none';
    })
}

//---------------------------------

function menu_display(toDisplay,right=false) //Normal display
{
    var target = document.querySelector(toDisplay);
    target.style.display = 'block';
    target.style.opacity= 1;
    if(right==false)
    target.style.left = '-10px';
    else
    target.style.right = '-10px';
    target.style.width = '100%';
    document.body.style.overflow = 'hidden';
}

//---------------------------------

function menu_close(toDisplay,right=false) //Normal display
{
    var target = document.querySelector(toDisplay);
    // target.style.display = 'none';
    if(right == false)
    target.style.left = '-2000px';
    else
    target.style.right = '-2000px';
    // target.style.width = 0;
    target.style.opacity= 0;
    document.body.style.overflow = 'scroll';
}

//---------------------------------

function box_nd(toDisplay) //Normal display
{
    var target = document.querySelector(toDisplay);
    target.style.display = 'block';
    document.body.style.overflow = 'hidden';
}

//---------------------------------

function box_nc(toDisplay) //Normal Close
{
    var target = document.querySelector(toDisplay);
    target.style.display = 'none';
    document.body.style.overflow = 'scroll';
}

//---------------------------------

function box_gd(toDisplay) //Global display
{
    var target = document.querySelector('#'+toDisplay);
    target.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

//---------------------------------

function box_gc(toDisplay) //Global close
{
    var target = document.querySelector('#'+toDisplay);
    target.style.display = 'none';
    document.body.style.overflow = 'scroll';
}

//---------------------------------

var box_test =0;
function box_dc(toDisplay,one=null,two=null,dform=null) //Display Close
{
    var target = document.querySelector('#'+toDisplay);
    if(one != null) var tone = document.querySelector('#'+one);
    if(two != null) var ttwo = document.querySelector('#'+two);
    
    if(box_test == 0)
    {
        target.style.display = 'block';
        if(one != null) tone.style.display = 'none';
        if(two != null) ttwo.style.display = dform != null ? dform : 'inline';
        box_test=1;
    }
    else
    {
        target.style.display = 'none';
        if(one != null) tone.style.display = dform != null ? dform : 'inline';
        if(two != null) ttwo.style.display = 'none';
        box_test=0;
    }


}