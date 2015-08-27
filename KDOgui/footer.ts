/// <reference path="typings/angular2/angular2.d.ts" />
import {Component, View, bootstrap} from 'angular2/angular2';

// Annotation section
@Component({ selector: 'footer' })
@View({ templateUrl: 'views/footer.html' })

// Component controller
class Footer {
    name: string;
    constructor() {
        this.name = 'Alice';
    }
}

bootstrap(Footer);