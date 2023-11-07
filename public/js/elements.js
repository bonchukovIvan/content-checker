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

function create_haystacks(response) 
{
    response.forEach((elem) => 
        {
        const checkbox = create('haystack__check', '', '', 'input');
        checkbox.type = 'checkbox';
        checkbox.name = 'remove_haystacks[]';
        checkbox.value = elem.id;
        
        const name = create('haystack__name', elem.name);
        const link = create('haystack__link', elem.link);
        const a = create('haystack__href', '', '', 'a');
        const div = create('haystack__title');
        div.appendChild(checkbox);
        div.appendChild(a);

        a.href = '/view/'+ elem.id;
        a.appendChild(name);
        const haystack = create('haystack');
        const needles = create('needles');

        if(elem.needles)
        {   
            const needles_arr = [];
            elem.needles.forEach((elem) => 
            {
                const needle_value = create('needle_value', elem.value);

                const needle = create('needle');
                needle.appendChild(needle_value);

                needles_arr.push(needle);
            });
            needles_arr.forEach((elem) => 
            {
                needles.appendChild(elem);
            });
        }
        
        haystack.appendChild(div);
        haystack.appendChild(link);
        haystack.appendChild(needles);

        const haystacks = document.getElementById('haystacks');
        haystacks.appendChild(haystack);
    });
}

function display_sites(response) {
    response.forEach(elem => 
    {
        const checkbox = create('sites__check', '', '', 'input');
        checkbox.type = 'checkbox';
        checkbox.name = 'removes[]';
        checkbox.value = elem.id;
        const div = create('site',);
        const a = create('sites__link', '', '', 'a');
        a.href = '/sites/'+elem.id;
        const link = create('sites__link', elem.link);
        const faculty_name = create('sites__faculty', elem.faculty.name);
        a.appendChild(link);
        a.appendChild(faculty_name);

        div.appendChild(a);
        const site = create('site');
        site.appendChild(checkbox);
        site.appendChild(div);

        const sites = document.getElementById('sites');
        sites.appendChild(site);
    });
}