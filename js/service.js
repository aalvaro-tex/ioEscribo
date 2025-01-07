function onListClick() {
    console.log('List clicked');
}

function showMenu(id, tipo) {
    console.log('Menu clicked');
    const menuEl = document.body.querySelector(`#usage-menu-${tipo}-${id}`);
    console.log('Abro el menu', id);
    menuEl.open = !menuEl.open;
}

function openCreateModal(titulo, accion) {
    console.log('Create modal opened');
    const modalEl = document.body.querySelector('#create-modal');
    const modalTitle = document.body.querySelector('#create-article-modal-title');
    modalTitle.innerHTML = 'Nuevo articulo';

    const title = document.getElementById('article-title');
    title.value = '';
    title.removeAttribute('readonly');

    const description = document.getElementById('description-text-input');
    description.value = '';
    description.removeAttribute('readonly');

    const content = document.getElementById('article-content');
    content.value = '';
    content.removeAttribute('readonly');

    const category = document.getElementById('article-category');
    category.removeAttribute('disabled');

    const updateButton = document.getElementById('update-article-button');
    updateButton.style.display = 'none';

    const createButton = document.getElementById('create-article-button');
    createButton.style.display = 'block';

    const id = document.getElementById('create-article-id');
    id.style.display = 'none';

    modalEl.open = true;
}

function doSelectOption(articulo, opcion) {
    console.log('Selecciono la opcion', opcion);
    switch (opcion) {
        case 1:
            console.log('Ver', articulo['id']);
            fillModal(articulo, opcion);
            disableModal();
            break;
        case 2:
            console.log('Editar', articulo['id']);
            fillModal(articulo, opcion);
            break;
        case 3:
            console.log('Eliminar', articulo['id']);
            openDeleteModal(articulo);
            break;
        case 4:
            console.log('Gestionar permisos', articulo);
            break;
        default:
            console.log('No definido', articulo);
            break;
    }
}

function loadArticleInfo(articulo) {

    const title = document.getElementById('article-title');
    title.value = articulo['titulo'];

    const fecha = document.getElementById('article-date');
    fecha.value = articulo['fecha_creacion'];

    const author = document.getElementById('article-author');
    author.value = articulo['Unombre'];
}

function openDeleteModal(articulo) {
    console.log('Delete modal opened');
    const modalEl = document.getElementById('delete-modal');
    const modelTitle = document.getElementById('delete-article-modal-title');
    modelTitle.innerHTML = 'Eliminar articulo';

    const id = document.getElementById('delete-article-id');
    id.value = articulo['id'];
    id.style.display = 'none';

    const title = document.getElementById('delete-article-title');
    title.value = articulo['titulo'];

    modalEl.open = true;
}

function openCollabModal(id_articulo, login) {
    const modalEl = document.getElementById('add-collab-modal');
    if (login === '') {
        console.log('Collab modal opened:', id_articulo);
        const modalTitle = document.getElementById('add-collab-modal-title');
        modalTitle.innerHTML = 'Añadir colaborador';

        const email = document.getElementById('collab-email');
        email.value = '';

        const deleteButton = document.getElementById('delete-collab-button');
        deleteButton.style.display = 'none';
        const addButton = document.getElementById('add-collab-button');
        addButton.style.display = 'block';
    } else {
        console.log('Delete modal opened:', id_articulo, login);
        const modalTitle = document.getElementById('add-collab-modal-title');
        modalTitle.innerHTML = 'Eliminar colaborador';
        const email = document.getElementById('collab-email');
        email.value = login;
        email.setAttribute('readonly', 'readonly');

        const deleteButton = document.getElementById('delete-collab-button');
        deleteButton.style.display = 'block';
        const addButton = document.getElementById('add-collab-button');
        addButton.style.display = 'none';
    }
    modalEl.open = true;
}

function fillModal(articulo, opcion) {
    const modalEl = document.body.querySelector('#create-modal');

    const title = document.getElementById('article-title');
    title.value = articulo['titulo'];

    const description = document.getElementById('description-text-input');
    description.value = articulo['descripcion'];

    const content = document.getElementById('article-content');
    content.value = articulo['contenido'];

    const category = document.getElementById('article-category');
    category.value = "auxilio";

    if (opcion === 1) {

        const modalTitle = document.body.querySelector('#create-article-modal-title');
        modalTitle.innerHTML = 'Ver articulo';
        const createButton = document.getElementById('create-article-button');
        createButton.style.display = 'none';
        const updateButton = document.getElementById('update-article-button');
        updateButton.style.display = 'none';

    } else if (opcion === 2) {

        const modalTitle = document.body.querySelector('#create-article-modal-title');
        modalTitle.innerHTML = 'Editar articulo';

        const title = document.getElementById('article-title');
        title.removeAttribute('readonly');

        const description = document.getElementById('description-text-input');
        description.removeAttribute('readonly');

        const content = document.getElementById('article-content');
        content.removeAttribute('readonly');

        const category = document.getElementById('article-category');
        category.removeAttribute('disabled');

        const createButton = document.getElementById('create-article-button');
        createButton.style.display = 'none';
        const updateButton = document.getElementById('update-article-button');
        updateButton.style.display = 'block';
    }

    const id = document.getElementById('create-article-id');
    id.value = articulo['id'];
    id.style.display = 'none';

    modalEl.open = true;
}

function disableModal() {
    const title = document.getElementById('article-title');
    title.setAttribute('readonly', 'readonly');

    const description = document.getElementById('description-text-input');
    description.setAttribute('readonly', 'readonly');

    const content = document.getElementById('article-content');
    content.setAttribute('readonly', 'readonly');

    const category = document.getElementById('article-category');
    category.setAttribute('disabled', true);
}

function closeModal(modalId) {
    const modalEl = document.getElementById(modalId);

    modalEl.open = false;
}

function viewPanel(panelId) {
    console.log('Tab clicked', panelId);
    const panelToShow = document.getElementById(panelId);
    console.log('Panel a mostrar', panelToShow);
    if (panelId === 'author-panel' || panelId === 'collab-panel') {
        authorPanel = document.getElementById('author-panel');
        authorPanel.style.display = 'none';
        collabPanel = document.getElementById('collab-panel');
        collabPanel.style.display = 'none';
    } else {
        editRequestsPanel = document.getElementById('edit-requests-panel');
        editRequestsPanel.style.display = 'none';
        otherNotificationsPanel = document.getElementById('other-notifications-panel');
        otherNotificationsPanel.style.display = 'none';
    }
    panelToShow.style.display = 'block';

}

function viewArticle(articulo) {

    const modalEl = document.getElementById('view-modal');

    const title = document.getElementById('article-title');
    title.value = articulo['titulo'];
    title.setAttribute('readonly', 'readonly');

    const description = document.getElementById('description-text-input');
    description.value = articulo['descripcion'];
    description.setAttribute('readonly', 'readonly');

    const content = document.getElementById('article-content');
    content.value = articulo['contenido'];
    content.setAttribute('readonly', 'readonly');

    const category = document.getElementById('view-category');
    category.setAttribute('disabled', true);

    modalEl.open = true;

}

function loadUserInfo(user) {
    console.log('Usuario:', user);
    const name = document.getElementById('user-name');
    name.value = user['nombre'];

    const email = document.getElementById('user-email');
    email.value = user['email'];

}

function viewPassword() {
    const password = document.getElementById('user-pssword');
    const icon = document.getElementById('pssword-icon');
    if (password.type === 'text') {
        icon.innerHTML = 'visibility';
        password.type = 'password';
    } else {
        icon.innerHTML = 'visibility_off';
        password.type = 'text';
    }
}

function openDeleteAccountModal(usuario) {
    const modalEl = document.getElementById('delete-account-modal');
    const modalTitle = document.getElementById('delete-account-modal-title');
    modalTitle.innerHTML = 'Eliminar cuenta';

    const email = document.getElementById('delete-account-login');
    email.value = usuario['email'];


    modalEl.open = true;
}