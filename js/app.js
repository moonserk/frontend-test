(function(){
	var app = angular.module('myApp', ['components']);
        app.controller('CertController',['$http', '$scope','$q', function($http,$scope,$q){

            this.people = obj1;
            this.requ = obj2;

            this.delsuccess = false;
            delsuccessPromise = $q.defer();

            this.sortBy = 'SubjectName';
            this.sortReverse = false;

            this.sort = {
                sortByName : 'SubjectName',
                sortById : 'CertificateId',
                sortByDate : 'NotBefore',
                sortByCreationTime : 'CreationTime',
                sortBySNILS : 'ExtensionData.SNILS'
            };

            this.checkBox = {
                pin : false,
                after : false
            };

            this.newCert = {};

            $scope.showPopUpMsg = false;
            $scope.openPopUp = function( ) {
                $scope.showPopUpMsg = true;
            }

            this.dateEq = function(value){
            	var date = value.replace("000", "");
            	this.date = new Date(date *  1000);
            	this.toDate = new Date();
            	if(this.date < this.toDate){
            		return true;
            	}
            	else{
            		return false;
            	}
            };

            this.rem = function(cert, delsuccess){
                var x = confirm('Удалить?');
                if (x && delsuccess) {
                    for(var key in obj1){
                        if(cert.CertificateId === obj1[key].CertificateId){
                            obj1.splice(key, 1);
                            break;
                        }
                    }
               }
               delsuccess = false;
            };

            this.add = function(delsuccess){
                console.log(delsuccess + "del");
                if (delsuccess) {
                    this.people.push(this.newCert);
                    certificates = JSON.stringify(obj1);
                    this.newCert = {};
                }
                delsuccess = false;
            };

            this.addCert = function(cert){
                $http.get('index.php?action=addCertificate').
                success(function(data){
                    if (data.success === true) {
                        delsuccess = true;
                        delsuccessPromise.resolve(delsuccess);
                    }
                    else{
                        alert(data.success);
                    }
                }).
                error(function(){
                    alert('Сервер не отвечает');
                });
                delsuccess = delsuccessPromise.promise;
                this.add(delsuccess);
                certificates = JSON.stringify(obj1);
                console.log(certificates);
            };

            this.deleteCert = function(cert){

                $http.get('index.php?action=deleteCertificate').
                success(function(data){
                    if (data.success === true) {
                        delsuccess = true;
                        delsuccessPromise.resolve(delsuccess);
                    }
                    else{
                        alert(data.success);
                    }
                }).
                error(function(){
                    alert('Сервер не отвечает');
                });
                delsuccess = delsuccessPromise.promise;
                this.rem(cert ,delsuccess);
                certificates = JSON.stringify(obj1);
                console.log(certificates);
            };


        }]);
     })();