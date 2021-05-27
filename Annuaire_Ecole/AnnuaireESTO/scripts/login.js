 let signActive = (choice) => {
    switch(choice) {
        case 'in':
            document.getElementById('signInToggler').classList.add('active');
            document.getElementById('signUpToggler').classList.remove('active');

            document.getElementById('signInDiv').classList.add('active');
            document.getElementById('signUpDiv').classList.remove('active');

            break;

            case 'up':
            document.getElementById('signUpToggler').classList.add('active');
            document.getElementById('signInToggler').classList.remove('active');

            document.getElementById('signUpDiv').classList.add('active');
            document.getElementById('signInDiv').classList.remove('active');

            break;
    }
}
let checkdesc = (choice) => {
   switch(choice) {
          case 'Enseignant':
           document.getElementById('idFi').style.display="none";
           document.getElementById('idLc').innerHTML="PPR :";

           break;

           case 'Fonctionnaire':
           document.getElementById('idFi').style.display="none";
           document.getElementById('idLc').innerHTML="PPR :";

           break;

           case 'Etudiant':
           document.getElementById('idFi').style.display="inline";
           document.getElementById('idLc').innerHTML="CNE :";

            break;


   }
}
let checkInputs = (element, choice) => {
    event.preventDefault();
    switch(choice) {
        case 'in':
            email = document.getElementById('signin_email').value;
            password = document.getElementById('signin_password').value;
            errors = document.getElementById('signin_errors');

            errors.innerHTML = '<br>';

            if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))) {
                errors.innerHTML += '* Email given is not valid';
            } else if(password.length < 5) {
                errors.innerHTML += '* Password given is too short';
            } else {
                element.parentNode.submit();
            }

            break;

        case 'up':
            name = document.getElementById('signup_name').value;
            prenom = document.getElementById('signup_prenom').value;
            telephone = document.getElementById('signup_tele').value;
            email = document.getElementById('signup_email').value;
            password = document.getElementById('signup_password').value;
            code = document.getElementById('signup_code').value;

            errors = document.getElementById('signup_errors');

            errors.innerHTML = '';

            if(name.trim().length == 0) {
                errors.innerHTML += '* Name cannot be empty';
            }else{
              if(prenom.trim().length == 0) {
                  errors.innerHTML += '* Prenom cannot be empty';
              }else{
                  if(telephone.length == 0){
                        errors.innerHTML += '* Telephone cannot be empty';
                  }else{
                      if(!(/^[0]{1}[6-7]{1}[0-9]{8}$/.test(telephone))){
                            errors.innerHTML += '* Telephone given is not valid';
                      }else {
                        if(code.length == 0){
                              errors.innerHTML += '* Code cannot be empty';
                        }else{
                            if(code.length < 8){
                                  errors.innerHTML += '* Code given is too short';
                            }else {
                                if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))) {
                                  errors.innerHTML += '* Email given is not valid';
                                }else {
                                  if(password.length == 0) {
                                       errors.innerHTML += '* Password cannot be empty';
                                   }else {
                                      if(password.length < 5) {
                                          errors.innerHTML += '* Password given is too short';
                                        }else{
                                          element.parentNode.submit();
                                        }
                                   }
                                }
                            }
                        }
                      }
                  }
              }
            }
            break;
    }
}
