/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';
import 'bootstrap';

// cf. https://symfony.com/doc/current/form/form_collections.html#allowing-new-tags-with-the-prototype
const addFormToCollection = (e) => {
    const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);
    const item = document.createElement('li');

    item.innerHTML = collectionHolder
        .dataset
        .prototype
        .replace(
            /__name__/g,
            collectionHolder.dataset.index
        );

    collectionHolder.appendChild(item);
    collectionHolder.dataset.index++;
};

document.addEventListener('DOMContentLoaded', () => {
    document
        .querySelectorAll('.add-form-collection-btn')
        .forEach(btn => {
            btn.addEventListener('click', addFormToCollection)
        });
});

// start the Stimulus application
import './bootstrap';
