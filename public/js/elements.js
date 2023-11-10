function create(class_name, inner_text = '', add_text = '', type = 'div') 
{
    const element = document.createElement(type);
    element.classList.add(class_name);
    if(inner_text) 
    {
        element.innerText = add_text+inner_text;
    }

    return element;
}

function changeSelected(needle, value) 
{
    const $select = document.querySelector('#'+needle);
    $select.value = value;
};

function display_sites(response) {
    response.forEach(elem => 
    {
        const checkbox = create('site__check', '', '', 'input');
        checkbox.type = 'checkbox';
        checkbox.name = 'removes[]';
        checkbox.value = elem.id;
        const head = create('site__head');
        const a = create('site__link', '', '', 'a');
        a.href = '/sites/'+elem.id;
        const link = create('sites__link', elem.link);

        
        a.appendChild(link);

        head.appendChild(a);
        
        head.appendChild(checkbox);
        const site = create('site');
        site.appendChild(head);
        if(elem.faculty_id) 
        {
            const faculty_name = create('sites__faculty', elem.faculty.name);
            site.appendChild(faculty_name);
        }
        
        const sites = document.getElementById('sites');
        sites.appendChild(site);
    });
}