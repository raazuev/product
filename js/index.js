document.addEventListener('DOMContentLoaded', () => {
    
    document.querySelectorAll('ul ul').removeClass('hidden');
    document.querySelectorAll('li').addEventListener('dblclick', function(e) {
        const sublist = li.querySelector('ul');
        if (sublist) {
            sublist.removeClass('hidden');
            sublist.addClass('visible');
        }
    });

})