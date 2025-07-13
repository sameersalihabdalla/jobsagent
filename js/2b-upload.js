var up = {
  // (A) INIT
  upForm : null, // html form
  upFile : null, // html file selector
  upGo : null,   // html submit button
  upStat : null, // html status display
  queue : [],    // upload queue
  init : () => {
    up.upForm = document.getElementById("upForm");
    up.upFile = document.getElementById("upFile");
    up.upGo = document.getElementById("upGo");
    up.upStat = document.getElementById("upStat");
    up.upGo.disabled = false;
  },

  // (B) ADD TO UPLOAD QUEUE
  add : () => { 
    // (B1) DISABLE SUBMIT BUTTON
    up.upGo.disabled = true;

    // (B2) GET FILES + RESET FIELD
    for (let f of up.upFile.files) { up.queue.push(f); }
    up.upForm.reset();

    // (B3) AJAX UPLOAD
    up.ajax();
    return false;
  },

  // (C) AJAX UPLOAD
  ajax : () => {
    // (C1) APPEND FIRST FILE IN QUEUE
    var data = new FormData();
    data.append("upFile", up.queue[0]);

    // (C2) UPLOAD
    fetch("2c-upload.php", { method:"POST", body:data })
    .then(res => res.text())
    .then(txt => {
      // (C2-1) SHOW UPLOAD STATUS
      up.upStat.innerHTML += `<div>${up.queue[0].name} - ${txt}</div>`;

      // (C2-2) NEXT FILE
      up.queue.shift();
      if (up.queue.length!=0) { up.ajax(); }
      else { up.upGo.disabled = false; }
    })
    .catch(err => {
      // (C2-3) ERROR!
      up.upStat.innerHTML += `<div>${err.message}</div>`;
      console.error(err);
    });
  }
};
window.onload = up.init;