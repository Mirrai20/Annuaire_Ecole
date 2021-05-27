function info(a){
        document.getElementById("Acceptation").style.visibility="hidden";
        document.getElementById("Gestion").style.visibility="hidden";


        if(a===0){
          document.getElementById("Acceptation").style.visibility="visible";
        }
        if(a===1){
          document.getElementById("Gestion").style.visibility="visible";
        }

      }
