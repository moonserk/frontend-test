<?php
/**
 * Created by PhpStorm.
 * User: Kirill
 * Date: 28-Jul-15
 * Time: 14:28 PM
 */

$cert1 = array(
    array(
        "CertificateId"=>"1",
        "IsTest"=>true,
        "NotAfter"=>"/Date(1464944879000)/",
        "NotBefore"=>"/Date(1433321879000)/",
        "Organization"=>"Такснет",
        "Email"=>"test1@test.com",
        "SubjectName"=>"Иванов",
        "HasPIN"=>false
    ),
    array(
        "CertificateId"=>"2",
        "IsTest"=>true,
        "NotAfter"=>"/Date(1433321879000)/",
        "NotBefore"=>"/Date(1433321879000)/",
        "Organization"=>"Такснет",
        "Email"=>"test2@test.com",
        "SubjectName"=>"Петров",
        "HasPIN"=>false
    ),
    array(
        "CertificateId"=>"3",
        "IsTest"=>false,
        "NotAfter"=>"/Date(1464944879000)/",
        "NotBefore"=>"/Date(1433321879000)/",
        "Organization"=>"Такснет",
        "Email"=>"test3@test.com",
        "SubjectName"=>"Сидоров",
    ),
    array(
        "CertificateId"=>"4",
        "IsTest"=>false,
        "NotAfter"=>"/Date(1464944879000)/",
        "NotBefore"=>"/Date(1433321879000)/",
        "Organization"=>"Такснет",
        "Email"=>"test4@test.com",
        "SubjectName"=>"Козявкин",
        "HasPIN"=>true
    ),

);

$cert2 = array(
    array(
        "CreationTime"=> '/Date(1437608924837)/',
        "ID"=>"1",
        "ExtensionData"=> array(
            "Passport"=>null,
            "SNILS"=>"222",
            "Email"=>"test1@test.com"
        ),
        "StatusCode"=>1
    ),
    array(
        "CreationTime"=> '/Date(1437408924837)/',
        "ID"=>"2",
        "ExtensionData"=> array(
            "Passport"=>null,
            "SNILS"=>"333",
            "Email"=>"test2@test.com"
        ),
        "StatusCode"=>1
    ),
    array(
        "CreationTime"=> '/Date(1437508924837)/',
        "ID"=>"3",
        "ExtensionData"=> array(
            "Passport"=>null,
            "SNILS"=>"444",
            "Email"=>"test3@test.com"
        ),
        "StatusCode"=>1
    ),
    array(
        "CreationTime"=> '/Date(1437208924837)/',
        "ID"=>"4",
        "ExtensionData"=> array(
            "Passport"=>null,
            "SNILS"=>"555",
            "Email"=>"test4@test.com"
        ),
        "StatusCode"=>1
    ),

);


$action = $_GET['action'] ?  $_GET['action'] : false;

$r = new stdClass();
if ($action == 'list') {
    $r->certificates = $cert1;
    $r->requests = $cert2;
    echo json_encode($r);
}

if ($action == 'deleteCertificate') {
    $r->success = true;
    echo json_encode($r);
    die();
}
if ($action == 'addCertificate') {
    $r->success = true;
    echo json_encode($r);
    die();
}
?>

<html ng-app="myApp">
<head>
    <title>Test</title>
    <script type="text/javascript" src="js/angular.min.js"></script>
    <script type="text/javascript" src="js/app.js"></script>
    <script type="text/javascript" src="js/components.js"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script>
        var certificates = '<?php echo json_encode($cert1) ?>';
        var requests = '<?php echo json_encode($cert2) ?>';
        var obj1 = JSON.parse(certificates, function(key, value){
            if(key === 'NotAfter' || key === 'NotBefore') return value.substring(6, 19);
            return value;
        });
        var obj2 = JSON.parse(requests, function(key, value){
            if(key === 'CreationTime') return value.substring(6, 19);
            return value;
        });
    </script>
</head>
<body class="container">
   <div ng-controller="CertController as sortt">
        <select ng-model="sortt.sortBy" class="form-control" ng-options="stars for stars in sortt.sort" title="Stars"></select>
        <tabs>
          <pane title="Certificates">
            <div ng-controller="CertController as cert">
                <br><a href ng-click="sortt.sortReverse = !sortt.sortReverse">{{ sortt.sortBy }}</a>
                <input type="checkbox" ng-model="cert.checkBox.pin"><label>HasPIN</label><input type="checkbox" ng-model="cert.checkBox.after"><label>NotAfter</label>
                <div class="product row" ng-repeat="certs in cert.people | orderBy : sortt.sortBy:sortt.sortReverse" ng-hide="!certs.HasPIN && cert.checkBox.pin || cert.checkBox.after && cert.dateEq(certs.NotAfter) || !certs.HasPIN && cert.checkBox.pin && cert.checkBox.after && cert.dateEq(certs.NotAfter)">
                     
                    <h3>{{certs.SubjectName}}<em class="pull-right">ID: {{certs.CertificateId}}</em>
                        <h4>NotAfter: ({{certs.NotAfter | date:'dd-MM-yyyy'}})
                            NotBefore: ({{certs.NotBefore | date:'dd-MM-yyyy'}})
                        </h4>
                    </h3>
                    <h4>Organization: {{certs.Organization}}</h4>
                    <h4>Email: {{certs.Email}}</h4>
                    <h4>HasPin: {{certs.HasPIN}}</h4>
                    <button class="pull-right" ng-click="cert.deleteCert(certs)">Удалить</button>
                    <button class="pull-right" ng-click="cert.addCert()">Добавить</button>
                </div>
            </div>
          </pane>
          <pane title="Requests">
            <div ng-controller="CertController as req">
                             <br><a href ng-click="sortt.sortReverse = !sortt.sortReverse">{{ sortt.sortBy }}</a>
                <div class="product row" ng-repeat="reqs in req.requ | orderBy : sortt.sortBy:sortt.sortReverse">
                    <h3>
                        CreationTime: {{reqs.CreationTime | date:'dd-MM-yyyy'}}<em class="pull-right">ID: {{reqs.ID}}</em>
                    </h3>
                    <h3>ExtensionDate:</h3>
                    <ul>
                        <li><h4>Passport: {{reqs.ExtensionDate.Passport}}</h4></li>
                        <li><h4>SNILS: {{reqs.ExtensionData.SNILS}}</h4></li>
                        <li><h4>Email: {{reqs.ExtensionDate.Email}}</h4></li>
                    </ul>
                </div>
            </div>
          </pane>
        </tabs>
    </div>
</body>
</html>