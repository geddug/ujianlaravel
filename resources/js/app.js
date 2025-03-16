import './bootstrap';
import 'flowbite';
import TomSelect from 'tom-select';
import 'tom-select/dist/css/tom-select.css';
function searchselect() {
    const elementoms = document.querySelectorAll('.searchselect');
    elementoms.forEach(elementom => {
        new TomSelect(elementom);
    });
}
window.searchselect = searchselect;