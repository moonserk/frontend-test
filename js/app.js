(function(){
	var app = angular.module('myApp', ['components']);
        app.controller('CertController', function(){
            this.people = obj1;

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

            this.checkBox = {
       			pin : false,
       			after : false
     		};
        });
        app.controller('ReqController', function(){
            this.requ = obj2;
        });
     })();