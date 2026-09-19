class Filter {

    constructor() {
        this.select = document.getElementById('pizza_categories');
        this.pizzas = document.querySelectorAll('.pizza-menu__item');
    }

    initEvents = () => {
        this.select.addEventListener('change', (e) => {
            const selectValue = e.target.value;
            console.log(selectValue);
            if(selectValue === 'all'){
                this.pizzas.forEach( pizza => pizza.classList.remove('hidden'))
            } else{
                this.pizzas.forEach( pizza => {
                    pizza.classList.remove('hidden');
                    if(!pizza.classList.contains(selectValue)){
                        pizza.classList.add('hidden');
                    }
                })
            }
        });
    }

    init = () => {
        this.initEvents();
    }

}

document.addEventListener('DOMContentLoaded', () => {
    const filterApp = new Filter();
    filterApp.init();
});