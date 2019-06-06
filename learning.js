const doc=document;
function createAjax(path,add,param1,param2,param3){
    return new Promise(resolve=>{
        var ajax = new XMLHttpRequest();
        ajax.params=add;
        ajax.open('POST', path, true);
        ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        ajax.send('param1=' + encodeURIComponent(param1)+'&&param2='+encodeURIComponent(param2)+'&&param3='+encodeURIComponent(param3));
        ajax.onreadystatechange=()=>{
            if (ajax.readyState==4) 
                ajax.status==200? resolve(ajax): alert(ajax.status+':'+ajax.statusText);                                  
        }
    });
}
function goLogin(){
    window.location='LoginForm.php';
}
function goRegistration(){
    window.location='registration.php';
}
function validateRegistration(ajax){
    if (!isNaN(ajax.responseText)){
        alert('Success registration');
        window.location="Welcome.php?id="+ajax.responseText;
    }
    else{
        alert(ajax.responseText);
        newValues(ajax.params);
    }
}
function Registration(event){
    event.preventDefault();
    let login=doc.getElementById('Rlogin').value;
    let password=doc.getElementById('Rpassword').value;
    let repPassword=doc.getElementById('repPassword').value;
    let values={'login':login,'password':password,'repPassword':repPassword};
    createAjax('checkRegistration.php',values,JSON.stringify(values)).then(validateRegistration)
}
function newValues(values){
    doc.getElementById('Rlogin').value=values.login;
    doc.getElementById('Rpassword').value=values.password;
    doc.getElementById('repPassword').value=values.repPassword;
}
function Exit(){
    let id=doc.getElementById('exit').value;
    createAjax('EXIT.php',null,id).then(()=>{window.location='Welcome.php'});
}
function addModule(){
    var module=prompt('Enter the name of the new module:');
    module==null? null: createAjax('addModule.php',null,module).then(printModule);
}
function printModule(ajax){
    if (+ajax.responseText==1)
        alert('This module already exist');
    else
    {
        let row=doc.createElement('div');
            row.className='row';
            let colLeft=doc.createElement('div');
                colLeft.className='col';
        row.appendChild(colLeft);
            let col5=doc.createElement('div');
                col5.className='col-5 module';
                let a=doc.createElement('a');
                    a.className='moduleLink';
                    a.href='module.php?module='+ajax.responseText;
                    a.innerText=ajax.responseText;
            col5.appendChild(a);
        row.appendChild(col5);
            let colRight=doc.createElement('div');
                    colRight.className='col';
        row.appendChild(colRight);
        let moduls=doc.getElementById('moduls');
            moduls.appendChild(row);
        alert(ajax.responseText+' was added');
    }
}
function goTask(id){
    window.location='newTask.php?id='+id;
}
function addTask(){
    var cases={};
    var select=doc.getElementById('select');
    let module=select.options[select.selectedIndex].text;
    let section=doc.getElementById('section').value;
    let theory=doc.getElementById('theory').value;
    let task=doc.getElementById('task').value;
    var params={'module':module,'section':section,'theory':theory,'task':task};
    for (let i = 1; i <=4; i++) 
        cases[i]=doc.getElementById('case'+i+'Input').value;
    createAjax('addTask.php',null,JSON.stringify(selectRight()),JSON.stringify(cases),JSON.stringify(params)).then(()=>{alert('The task was added')});
}
function selectRight(){
    let right=Array();
    for (let i = 1; i <= 4; i++){
        let check=doc.getElementById('case'+i).checked;
        if (check==true){
            let value=doc.getElementById('case'+i+'Input').value;
            value!==''? right[right.length]=value : alert('Case'+i+' is not defined');
        } 
    }
    return right; 
}
function getCases(){
    cases=Array();
    for (let i = 1; i <= 4; i++){
        let checkbox=doc.getElementById('Case'+i+'InQuiz');
        checkbox!=null && checkbox.checked==true? cases[cases.length]=doc.getElementById('Case'+i+'Variant').innerText : null;
    }
    return cases;
}
function Answer(){
    let id=doc.getElementById('idInQuiz').value;
    let hidden=doc.getElementById('hidden').value;
        let qzNum=+JSON.parse(hidden)[2];
        let moduleIndex=JSON.parse(hidden)[0].substring(0,1);
        let moduleName=JSON.parse(hidden)[0].substring(2);
        let section=JSON.parse(hidden)[1];
        var arr={'moduleName':moduleName,'moduleIndex':moduleIndex,'section':section,'qzNum':qzNum,'id':id};
    createAjax('checkAnswer.php',arr,JSON.stringify(getCases()),hidden).then(decide)    
}
function decide(ajax){
    let params=ajax.params;
    switch (+ajax.responseText){
        case 1:
            alert('Section "'+params.section+'" complete');
            setComplete(params.moduleName,params.moduleIndex,params.section,params.id);
            break;
        case 2:
            params.qzNum+=1;
            window.location='quiz.php?module='+params.moduleName+'&&section='+params.section+'&&qz='+params.qzNum+'&&id='+params.id;
            break;
        default:
            alert('Incorrect answer');
            break;
    }
}
function setComplete(moduleName,moduleIndex,section,id){
    var json={'moduleIndex':moduleIndex,'moduleName':moduleName,'section':section,'id':id};
    createAjax('setComplete.php',json,JSON.stringify(json)).then(backToModule)   
}
function backToModule(ajax){
    let params=ajax.params;
    window.location='module.php?module='+params.moduleName+'&&index='+params.moduleIndex+'&&id='+params.id;
}
function support(event){
    event.preventDefault();
    let login=doc.getElementById('hhhSupport').value;
    let msg=doc.getElementById('supportMessage').value;
    let params={'login':login,'message':msg};
    createAjax('sendMSG.php',null,JSON.stringify(params)).then(()=>{alert('Your message has been sent.Check for answer in your private messages')});
}
function drawProgress(progress){
    let canvas=doc.getElementById('canvas');
    let ctx=canvas.getContext('2d');

    ctx.beginPath();
    ctx.fillStyle='rgb(41,45,42)';
    ctx.arc(canvas.width*0.5,canvas.height*0.5,162,0,2*Math.PI,false);
    ctx.fill();

    ctx.beginPath();
    ctx.strokeStyle='rgb(40,167,69)';
    ctx.lineWidth=15;
    ctx.arc(canvas.width*0.5,canvas.height*0.5,170,0,progress*0.01*2*Math.PI,false);
    ctx.stroke();
    ctx.beginPath();
    ctx.font = 'bold 60px sans-serif';// стиль текста
    ctx.fillStyle ='rgb(40,167,69)';
    ctx.fillText(progress+'%',canvas.width*0.5-55,canvas.height*0.5+20);
}
function getID(){
    return id=doc.getElementById('hiddenInAccount').value;
}
function clearMain(){
    let main=doc.getElementById('main');
    main.innerHTML=null;
}
function getMessages(ajax){
    doc.getElementById('main').innerHTML=ajax.responseText;
}
function viewMessages(){
    function doOnClick(){
        clearMain();
        createAjax('getDialog.php',null,this.innerText,getID()).then(getMessages);
    }
    let senders=doc.getElementsByClassName('category-title');
    let lngt=senders.length;
    for (let i = 0; i < lngt; i++)
        senders[i].onclick=doOnClick;
}
function sendAnswer(){
    let sender=doc.getElementById('sender').innerText;
    let answer=doc.getElementById('answer').value;
    createAjax('sendAnswer.php',null,sender,answer,getID()).then(()=>{alert('Your answer has been send')});
}
