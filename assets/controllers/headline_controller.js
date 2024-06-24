import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['title', 'picture', 'content', 'buttonChange'];

    connect() {
        this.buttonChangeTarget.addEventListener('click', this.changeHeadline.bind(this));
    }

    changeHeadline() {
        fetch("/api/articles/random")
            .then(response => response.json())
            .then(article => this.updateHeadline(article[0].title, article[0].picture, article[0].summary));
    }

    updateHeadline(title, picture, content) {
        this.titleTarget.innerHTML = title;
        this.pictureTarget.setAttribute('src', '/uploads/' + picture);
        this.pictureTarget.setAttribute('alt', title);
        this.contentTarget.innerHTML = content;
    }
}
