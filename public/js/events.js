const iconoMenu=document.getElementById("mobile_menu");
iconoMenu.addEventListener('click',()=>{
    const nav=document.getElementById("nav");
    nav.classList.toggle("oculto"); 
});