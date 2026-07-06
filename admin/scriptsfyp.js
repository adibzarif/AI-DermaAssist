function openModal(){

    const modal = document.getElementById('modal');

    if(modal){
        modal.classList.remove('hidden');
    }

    // PRODUCT FORM
    if(document.getElementById('id')){
        document.getElementById('id').value = '';
    }

    if(document.getElementById('name')){
        document.getElementById('name').value = '';
    }

    if(document.getElementById('brand')){
        document.getElementById('brand').value = '';
    }

    if(document.getElementById('image')){
        document.getElementById('image').value = '';
    }

    if(document.getElementById('desc')){
        document.getElementById('desc').value = '';
    }

    // RESET INGREDIENT
    if(typeof selectedIngredients !== 'undefined'){

        selectedIngredients.length = 0;

        if(typeof renderIngredients === 'function'){
            renderIngredients();
        }
    }

    // RESET SKIN TYPE
    if(typeof selectedSkinTypes !== 'undefined'){

        selectedSkinTypes.length = 0;

        if(typeof renderSkinTypes === 'function'){
            renderSkinTypes();
        }
    }

    // RESET SKIN TONE
    if(typeof selectedSkinTones !== 'undefined'){

        selectedSkinTones.length = 0;

        if(typeof renderSkinTones === 'function'){
            renderSkinTones();
        }
    }

    // RESET SKIN PROBLEM
    if(typeof selectedSkinProblems !== 'undefined'){

        selectedSkinProblems.length = 0;

        if(typeof renderSkinProblems === 'function'){
            renderSkinProblems();
        }
    }
}

function closeModal(){
    const modal = document.getElementById('modal');
    if(modal) modal.classList.add('hidden');
}

// ================= INGREDIENT MODAL =================

function openIngredientModal(){

    const modal =
    document.getElementById('ingredientModal');

    if(!modal){
        console.log('ingredientModal TAK JUMPA');
        return;
    }

    modal.classList.remove('hidden');

    // RESET ARRAY
    if(typeof selectedIngredients !== 'undefined'){
        selectedIngredients.length = 0;
    }

    // RESET TAG UI
    if(typeof renderIngredients === 'function'){
        renderIngredients();
    }

    // RESET PRODUCT
    const product =
    document.getElementById('ingredient_product');

    if(product){
        product.value = '';
    }
}

function closeIngredientModal(){

    const modal =
    document.getElementById('ingredientModal');

    if(modal){
        modal.classList.add('hidden');
    }
}

function editProduct(data){
    const modal = document.getElementById('modal');
    if(modal) modal.classList.remove('hidden');

    if(document.getElementById('id')) document.getElementById('id').value = data.id;
    if(document.getElementById('name')) document.getElementById('name').value = data.name;
    if(document.getElementById('brand')) document.getElementById('brand').value = data.brand;
    if(document.getElementById('image')) document.getElementById('image').value = data.image_url;
    if(document.getElementById('desc')) document.getElementById('desc').value = data.description;
}


function toggleDeleteMode(productId){

    const tags = document.querySelectorAll(`[data-product='${productId}']`);

    tags.forEach(tag => {

        const btn = tag.querySelector('.delete-btn');

        btn.classList.toggle('hidden');

    });
}

// ================= USER MODAL =================

function openUserModal(){

    const modal = document.getElementById('userModal');

    modal.style.display = 'flex';

    document.getElementById('userForm')
    .action = 'index.php?action=saveUser';

    document.getElementById('user_id').value = '';
    document.getElementById('user_name').value = '';
    document.getElementById('user_email').value = '';
    document.getElementById('user_password').value = '';

    document.getElementById('passwordDiv')
    .style.display = 'block';
}

function closeUserModal(){

    document.getElementById('userModal')
    .style.display = 'none';
}

function editUser(btn){

    const modal =
    document.getElementById('userModal');

    modal.style.display = 'flex';

    document.getElementById('userForm')
    .action = 'index.php?action=updateUser';

    document.getElementById('user_id').value =
    btn.dataset.id;

    document.getElementById('user_name').value =
    btn.dataset.name;

    document.getElementById('user_email').value =
    btn.dataset.email;

    document.getElementById('passwordDiv')
    .style.display = 'none';
}

// ================= PRODUCT PRICE MODAL =================

function openPriceModal(){

    const modal =
    document.getElementById('priceModal');

    modal.classList.remove('hidden');

    document.getElementById('priceForm').reset();

    document.getElementById('priceForm')
    .action = 'index.php?action=savePrice';
}

function closePriceModal(){

    document.getElementById('priceModal')
    .classList.add('hidden');
}

function editPrice(btn){

    const modal =
    document.getElementById('priceModal');

    modal.classList.remove('hidden');

    document.getElementById('priceForm')
    .action = 'index.php?action=updatePrice';

    // ID
    document.getElementById('price_id').value =
    btn.dataset.id;

    // PRODUCT
    document.getElementById('price_product').value =
    btn.dataset.product;

    // STORE
    document.getElementById('price_store').value =
    btn.dataset.store;

    // PRICE
    document.getElementById('price_value').value =
    btn.dataset.price;

    document.getElementById('price_url').value =
    btn.dataset.url;
}

// ================= SKIN TYPE TAG SELECT =================

const selectedSkinTypes = [];

const skinTypeSelect =
document.getElementById('skinTypeSelect');

if(skinTypeSelect){

skinTypeSelect.addEventListener('change', function(){

    const id = this.value;

    const text =
    this.options[this.selectedIndex].text;

    if(!id) return;

    // avoid duplicate
    const exists = selectedSkinTypes.find(
        item => item.id == id
    );

    if(exists){
        return;
    }

    // push
    selectedSkinTypes.push({
        id,
        text
    });

    renderSkinTypes();

    this.value = '';
});

}

// ================= RENDER =================

    function renderSkinTypes(){

        const container =
        document.getElementById('selectedSkinTypes');

        const hidden =
        document.getElementById('hiddenSkinInputs');

        container.innerHTML = '';

        hidden.innerHTML = '';

        selectedSkinTypes.forEach((item, index) => {

            // TAG UI
            container.innerHTML += `

            <div class="bg-green-50 text-gray-800 px-3 py-2 rounded-lg text-sm flex items-center gap-2">

                ${item.text}

                <button
                    type="button"
                    onclick="removeSkinType(${index})"
                    class="text-red-500"
                >
                    ✕
                </button>

            </div>
            `;

            // HIDDEN INPUT
            hidden.innerHTML += `

            <input
                type="hidden"
                name="skintype_id[]"
                value="${item.id}"
            >
            `;
        });
    }

// ================= REMOVE =================

function removeSkinType(index){

    selectedSkinTypes.splice(index, 1);

    renderSkinTypes();
}

// ================= EDIT PST =================

function editPST(productId, typeIds){

    // OPEN MODAL
    const modal =
    document.getElementById('modal');

    if(modal){
        modal.classList.remove('hidden');
    }

    // FORM ACTION
    document.getElementById('pstForm')
    .action = 'index.php?action=updatePST';

    // PRODUCT
    document.querySelector(
        '#pstForm select[name="product_id"]'
    ).value = productId;

    // RESET
    selectedSkinTypes.length = 0;

    // IDS ARRAY
    const ids = typeIds.split(',');

    const select =
    document.getElementById('skinTypeSelect');

    ids.forEach(id => {

        const option =
        select.querySelector(
            `option[value="${id}"]`
        );

        if(option){

            selectedSkinTypes.push({
                id: id,
                text: option.text
            });
        }
    });

    // RENDER
    renderSkinTypes();
}

// ================= SKIN TONE TAG SELECT =================

const selectedSkinTones = [];

const skinToneSelect =
document.getElementById('skinToneSelect');

if(skinToneSelect){

skinToneSelect.addEventListener('change', function(){

    const id = this.value;

    const text =
    this.options[this.selectedIndex].text;

    if(!id) return;

    const exists = selectedSkinTones.find(
        item => item.id == id
    );

    if(exists){
        return;
    }

    selectedSkinTones.push({
        id,
        text
    });

    renderSkinTones();

    this.value = '';
});

}

function renderSkinTones(){

    const container =
    document.getElementById('selectedSkinTones');

    const hidden =
    document.getElementById('hiddenSkinToneInputs');

    container.innerHTML = '';

    hidden.innerHTML = '';

    selectedSkinTones.forEach((item, index) => {

        container.innerHTML += `

        <div class="bg-purple-100 text-gray-800 px-3 py-2 rounded-lg text-sm flex items-center gap-2">

            ${item.text}

            <button
                type="button"
                onclick="removeSkinTone(${index})"
                class="text-red-500"
            >
                ✕
            </button>

        </div>
        `;

        hidden.innerHTML += `

        <input
            type="hidden"
            name="skintone_id[]"
            value="${item.id}"
        >
        `;
    });
}

function removeSkinTone(index){

    selectedSkinTones.splice(index, 1);

    renderSkinTones();
}

// ================= EDIT PSTONE =================

function editPSTone(productId, toneIds){

    // OPEN MODAL
    const modal =
    document.getElementById('modal');

    if(modal){
        modal.classList.remove('hidden');
    }

    // FORM ACTION
    document.getElementById('pstoneForm')
    .action = 'index.php?action=updatePSTone';

    // PRODUCT
    document.querySelector(
        '#pstoneForm select[name="product_id"]'
    ).value = productId;

    // RESET
    selectedSkinTones.length = 0;

    // IDS ARRAY
    const ids = toneIds.split(',');

    const select =
    document.getElementById('skinToneSelect');

    ids.forEach(id => {

        const option =
        select.querySelector(
            `option[value="${id}"]`
        );

        if(option){

            selectedSkinTones.push({
                id: id,
                text: option.text
            });
        }
    });

    // RENDER
    renderSkinTones();
}

// ================= SKIN PROBLEM TAG SELECT =================

const selectedSkinProblems = [];

const skinProblemSelect =
document.getElementById('skinProblemSelect');

if(skinProblemSelect){

skinProblemSelect.addEventListener('change', function(){

    const id = this.value;

    const text =
    this.options[this.selectedIndex].text;

    if(!id) return;

    const exists = selectedSkinProblems.find(
        item => item.id == id
    );

    if(exists){
        return;
    }

    selectedSkinProblems.push({
        id,
        text
    });

    renderSkinProblems();

    this.value = '';
});

}

function renderSkinProblems(){

    const container =
    document.getElementById('selectedSkinProblems');

    const hidden =
    document.getElementById('hiddenSkinProblemInputs');

    container.innerHTML = '';

    hidden.innerHTML = '';

    selectedSkinProblems.forEach((item, index) => {

        container.innerHTML += `

        <div class="bg-blue-100 text-gray-800 px-3 py-2 rounded-lg text-sm flex items-center gap-2">

            ${item.text}

            <button
                type="button"
                onclick="removeSkinProblem(${index})"
                class="text-red-500"
            >
                ✕
            </button>

        </div>
        `;

        hidden.innerHTML += `

        <input
            type="hidden"
            name="problem_id[]"
            value="${item.id}"
        >
        `;
    });
}

function removeSkinProblem(index){

    selectedSkinProblems.splice(index, 1);

    renderSkinProblems();
}

function editPSP(productId, problemIds){

    // OPEN MODAL
    const modal =
    document.getElementById('modal');

    if(modal){
        modal.classList.remove('hidden');
    }

    // SET FORM
    document.getElementById('pspForm')
    .action = 'index.php?action=updatePSP';

    // SET PRODUCT
    document.querySelector(
        '#pspForm select[name="product_id"]'
    ).value = productId;

    // RESET ARRAY
    selectedSkinProblems.length = 0;

    // IDS
    const ids = problemIds.split(',');

    const select =
    document.getElementById('skinProblemSelect');

    ids.forEach(id => {

        const option =
        select.querySelector(
            `option[value="${id}"]`
        );

        if(option){

            selectedSkinProblems.push({
                id: id,
                text: option.text
            });
        }
    });

    // RENDER TAG
    renderSkinProblems();
}
// ================= PRODUCT INGREDIENT =================

const selectedIngredients = [];

// OPEN MODAL
function openProductIngredientModal(){

    const modal =
    document.getElementById('ingredientModal');

    if(!modal) return;

    modal.classList.remove('hidden');

    // reset
    selectedIngredients.length = 0;

    renderIngredients();

    document.getElementById(
        'ingredient_product'
    ).value = '';
}

// CLOSE MODAL
function closeProductIngredientModal(){

    const modal =
    document.getElementById('ingredientModal');

    if(modal){
        modal.classList.add('hidden');
    }
}

// SELECT
const ingredientSelect =
document.getElementById('ingredientSelect');

if(ingredientSelect){

    ingredientSelect.addEventListener('change', function(){

        const id = this.value;

        const text =
        this.options[this.selectedIndex].text;

        if(!id) return;

        const exist =
        selectedIngredients.find(
            item => item.id == id
        );

        if(exist) return;

        selectedIngredients.push({
            id,
            text
        });

        renderIngredients();

        this.value = '';
    });
}

// RENDER
function renderIngredients(){

    const container =
    document.getElementById(
        'selectedIngredients'
    );

    const hidden =
    document.getElementById(
        'hiddenIngredientInputs'
    );

    if(!container || !hidden) return;

    container.innerHTML = '';
    hidden.innerHTML = '';

    selectedIngredients.forEach((item,index)=>{

        container.innerHTML += `

        <div class="bg-green-100 text-gray-800 px-3 py-2 rounded-lg text-sm flex items-center gap-2">

            ${item.text}

            <button
                type="button"
                onclick="removeIngredient(${index})"
                class="text-red-500"
            >
                ✕
            </button>

        </div>
        `;

        hidden.innerHTML += `

        <input
            type="hidden"
            name="ingredients[]"
            value="${item.id}"
        >
        `;
    });
}

// REMOVE
function removeIngredient(index){

    selectedIngredients.splice(index,1);

    renderIngredients();
}

// EDIT
function editIngredient(productId, ingredientIds){

    openProductIngredientModal();

    document.getElementById(
        'ingredient_product'
    ).value = productId;

    selectedIngredients.length = 0;

    const ids = ingredientIds.split(',');

    const select =
    document.getElementById('ingredientSelect');

    ids.forEach(id => {

        const option =
        select.querySelector(
            `option[value="${id}"]`
        );

        if(option){

            selectedIngredients.push({
                id,
                text: option.text
            });
        }
    });

    renderIngredients();
}

// ================= INGREDIENT CRUD MODAL =================

function openIngredientModal(){

    const modal =
    document.getElementById('ingredientModal');

    if(modal){
        modal.classList.remove('hidden');
    }

    document.getElementById('ingredient_id').value = '';
    document.getElementById('ingredient_name').value = '';
    document.getElementById('ingredient_safety').value = 'safe';
    document.getElementById('ingredient_notes').value = '';
}

function closeIngredientModal(){

    const modal =
    document.getElementById('ingredientModal');

    if(modal){
        modal.classList.add('hidden');
    }
}

function editIngredientData(id, name, safety, notes){

    openIngredientModal();

    document.getElementById('ingredient_id').value = id;
    document.getElementById('ingredient_name').value = name;
    document.getElementById('ingredient_safety').value = safety;
    document.getElementById('ingredient_notes').value = notes;

    document.getElementById('ingredientForm')
    .action = 'index.php?action=updateIngredient';
}