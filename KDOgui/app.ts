/// <reference path="typings/angular2/angular2.d.ts" />
import {Component, View, bootstrap} from 'angular2/angular2';
// Annotation section
@Component({ selector: 'app' })
@View(
    {
        templateUrl: 'views/app.html',
        directives: [ChildComponent]
    }
)

// Component controller
class App {
    name: string;
    constructor() {
        this.name = 'Alice';
    }
}

bootstrap(App);