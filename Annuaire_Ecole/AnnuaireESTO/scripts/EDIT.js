let verifInputs = () => {
            name = document.getElementById('EDIT_name').value;
            prenom = document.getElementById('EDIT_prenom').value;
            telephone = document.getElementById('EDIT_tele').value;
            email = document.getElementById('EDIT_email').value;
            password = document.getElementById('EDIT_password').value;

            errors = document.getElementById('EDIT_errors');


            if(name.trim().length == 0) {
                errors.innerHTML = '* Name cannot be empty';
            }else{
              if(prenom.trim().length == 0) {
                  errors.innerHTML = '* Prenom cannot be empty';
              }else{
                  if(telephone.length == 0){
                        errors.innerHTML = '* Telephone cannot be empty';
                  }else{
                      if(!(/^[0]{1}[6-7]{1}[0-9]{8}$/.test(telephone))){
                            errors.innerHTML = '* Telephone given is not valid';
                      }else {

                          if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))) {
                                errors.innerHTML = '* Email given is not valid';
                              }else {
                                  if(password.length == 0) {
                                       errors.innerHTML = '* Password cannot be empty';
                                   }else {
                                      if(password.length < 5) {
                                          errors.innerHTML = '* Password given is too short';
                                        }else {
                                          return true;
                                        }
                                   }
                                }
                            }
                        }
                      }
                  }
                  return false;
              }
