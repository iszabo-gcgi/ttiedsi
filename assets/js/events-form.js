(function(){
    document.getElementById('show_next_organizer').addEventListener('click', show_next_organizer);
    const remove_buttons = document.querySelectorAll('form[action*="submit-event"] .remove-field');
    for (const button of remove_buttons ) {
        button.addEventListener('click', remove_this_organizer);
    }

    function show_next_organizer(event){
        event.preventDefault();
        const first_hidden_element = event.target.parentNode.parentNode.querySelector('.gfield_visibility_hidden');
        if ( first_hidden_element ) {
            first_hidden_element.classList.add('gfield_visibility_visible');
            first_hidden_element.classList.remove('gfield_visibility_hidden');
            first_hidden_element.nextSibling.classList.add('gfield_visibility_visible');
            first_hidden_element.nextSibling.classList.remove('gfield_visibility_hidden');
        }
    }

    function remove_this_organizer(event){
        event.preventDefault();
        event.target.parentNode.classList.add('gfield_visibility_hidden');
        event.target.parentNode.classList.remove('gfield_visibility_visible');
        event.target.parentNode.previousSibling.classList.add('gfield_visibility_hidden');
        event.target.parentNode.previousSibling.classList.remove('gfield_visibility_visible');
    }
})();