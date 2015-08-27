/// <reference path="typings/angular2/angular2.d.ts" />
import {Component, View, bootstrap} from 'angular2/angular2';

// Annotation section
@Component({ selector: 'topBar' })
@View({ templateUrl: 'views/topBar.html' })

// Component controller
class TopBar {
    name: string;
    constructor() {
        this.name = 'Alice';
    }
}

bootstrap(TopBar);