const inputItem = document.getElementById('input-item');
const btnAddItem = document.getElementById('btn-add-item');
const listContainer = document.querySelector('.list');
const database = new Map();

btnAddItem.addEventListener('click', () => {
    const itemKey = inputItem.value.toUpperCase();
    const itemValue = inputItem.value;
 
  
    // membuat list
    const listItem = document.createElement('li');
    const textItem = document.createElement('a');
    const addnilai = document.createElement('h1');
    const btnDelete = document.createElement('button');
    const counter = document.createElement('button');

    var i =1;
    counter.textContent = i;
    
    //jika ngga isi apa2
    if (itemValue === '') {
      alert("Item Name can't be blank");
      inputItem.focus();
      return;
    }

    //jika double list maka muncul pemberitahuan
    if (database.has(itemKey)) {
      const duplicateConfirm = confirm('Item  "' + itemValue + '" sudah ada. klik ok jika ingin menambahkan lagi');

      if (duplicateConfirm) {
        
          const getCounter = document.getElementById(itemKey);
          i = Number(getCounter.textContent)
          getCounter.textContent = (i + 1);

      }
      inputItem.value = '';
      inputItem.focus();
      return;
  }
  counter.setAttribute("id", itemKey); 
  
    database.set(itemKey, itemValue);
  

    listItem.classList.add('list-item'); // menambah Class



    textItem.textContent = itemValue;
    btnDelete.textContent = 'Delete';
  listItem.append(textItem,btnDelete,counter);
  listContainer.appendChild(listItem);
  
 
    btnDelete.addEventListener('click', () => {
      const delConfirm = confirm("klik jika ingin menghapus item")
      if (delConfirm) {
          const getCounter = document.getElementById(itemKey);

          if (getCounter.textContent === "1") {
              listContainer.removeChild(listItem);
          } else {
              i = Number(getCounter.textContent);
              getCounter.textContent = i - 1;
          }
      }
      inputItem.focus();
      return;
  });

  inputItem.value = '';
  inputItem.focus();

})