(() => {
 const products=window.TMC_PRODUCTS||[]; const cart=new Map(); const grid=document.getElementById('productGrid');
 if(!grid)return;
 const money=n=>'$'+Number(n).toFixed(2);
 const fmtQty=n=>Number(n)%1===0?Number(n).toFixed(0):Number(n).toFixed(2);
 const itemsEl=document.getElementById('cartItems');
 function render(){let subtotal=0;itemsEl.innerHTML='';if(!cart.size){itemsEl.innerHTML='<div class="empty">Select menu items to begin.</div>';}
 cart.forEach((v,id)=>{const line=v.price*v.qty;subtotal+=line;const row=document.createElement('div');row.className='cart-row';row.innerHTML=`<div class="cart-product"><b></b><small>${money(v.price)} each</small></div><div class="qty-control"><button type="button" data-dec="${id}">−</button><span>${fmtQty(v.qty)}</span><button type="button" data-inc="${id}">+</button></div><b>${money(line)}</b>`;row.querySelector('.cart-product b').textContent=v.name;itemsEl.appendChild(row);});
 document.getElementById('subtotal').textContent=money(subtotal);document.getElementById('total').textContent=money(subtotal);document.getElementById('cartJson').value=JSON.stringify([...cart].map(([id,v])=>({id:Number(id),qty:v.qty})));const paid=Number(document.getElementById('paidAmount').value||0);document.getElementById('changeAmount').textContent=money(Math.max(0,paid-subtotal));document.getElementById('completeSale').disabled=!cart.size||paid+0.0001<subtotal;
 }
 grid.addEventListener('click',e=>{const b=e.target.closest('.product-tile');if(!b)return;const id=Number(b.dataset.id);const p=products.find(x=>x.id===id);if(!p)return;const v=cart.get(id)||{...p,qty:0};v.qty++;cart.set(id,v);render();});
 itemsEl.addEventListener('click',e=>{const inc=e.target.closest('[data-inc]'),dec=e.target.closest('[data-dec]');if(inc){const v=cart.get(Number(inc.dataset.inc));v.qty++;}if(dec){const id=Number(dec.dataset.dec),v=cart.get(id);v.qty--;if(v.qty<=0)cart.delete(id);}render();});
 document.getElementById('clearCart').addEventListener('click',()=>{cart.clear();render();});document.getElementById('paidAmount').addEventListener('input',render);
 document.querySelectorAll('.cat-tab').forEach(tab=>tab.addEventListener('click',()=>{document.querySelectorAll('.cat-tab').forEach(t=>t.classList.remove('active'));tab.classList.add('active');filter();}));
 function filter(){const cat=document.querySelector('.cat-tab.active').dataset.category,term=document.getElementById('productSearch').value.toLowerCase();document.querySelectorAll('.product-tile').forEach(tile=>{tile.hidden=!( (cat==='all'||tile.dataset.category===cat) && tile.dataset.name.toLowerCase().includes(term));});}
 document.getElementById('productSearch').addEventListener('input',filter);document.getElementById('checkoutForm').addEventListener('submit',e=>{if(!cart.size){e.preventDefault();alert('Add products first.');}});render();
})();
