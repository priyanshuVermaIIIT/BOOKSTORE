document.addEventListener("DOMContentLoaded", ()=>{
    const f1 = document.querySelector("#f1");
    const f2 = document.querySelector("#f2");

    document.querySelector("#linkF2").addEventListener("click",e=>{
        e.preventDefault();
        // console.log("Function ran");
        f1.classList.add("form--hidden");
        f2.classList.remove("form--hidden");
    })

    document.querySelector("#linkF1").addEventListener("click",e=>{
        e.preventDefault();
        f1.classList.remove("form--hidden");
        f2.classList.add("form--hidden");
    })
})
var el = document.getElementById("submit");
el.addEventListener("keypress", function(event) {
  if (event.key === "Enter") {
    alert(event.key  + " " + event.which);
    event.preventDefault();
  }
});