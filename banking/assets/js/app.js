function g(x){return document.getElementById(x)}

function openCreate(){
  g('ov-create').classList.add('open')
}

function createAccount(){
  let fd=new FormData()
  fd.append('action','create')
  fd.append('holder_name',g('c-name').value)
  fd.append('balance',g('c-bal').value)

  fetch('api.php',{method:'POST',body:fd})
  .then(r=>r.json())
  .then(()=>loadAccounts())
}

function loadAccounts(){
  fetch('api.php?action=list')
  .then(r=>r.json())
  .then(rows=>{
    let h=''
    rows.forEach((r,i)=>{
      h+=`<tr>
        <td>${i+1}</td>
        <td>${r.account_number}</td>
        <td>${r.holder_name}</td>
        <td>${r.balance}</td>
        <td>${r.created_at}</td>
        <td><button onclick="delAcc(${r.id})">Delete</button></td>
      </tr>`
    })
    g('acc-tbody').innerHTML=h
  })
}

function delAcc(id){
  let fd=new FormData()
  fd.append('action','delete')
  fd.append('id',id)
  fetch('api.php',{method:'POST',body:fd}).then(()=>loadAccounts())
}

loadAccounts()