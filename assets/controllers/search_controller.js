import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['input', 'results'];

    connect() {
        this.inputTarget.addEventListener('input', this.search.bind(this));
    }

    search() {
        let search = this.inputTarget.value;
        fetch("/api/articles/search?q="+search)
            .then(response => response.json())
            .then(articles => this.displayResults(articles));
    }

    displayResults(articles) {
        this.resultsTarget.innerHTML = "";
        for(let article of articles) {
            const li = document.createElement("li");
            li.innerHTML = `<a href="/articles/${article.id}">${article.title}</a>`;
            this.resultsTarget.append(li);
        }
    }
}
