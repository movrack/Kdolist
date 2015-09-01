/// <reference path="../typings/angular2/angular2.d.ts" />

declare function require(string): string;
require("!style!css!less!../assets/less/app.less");

import {Component, View, bootstrap} from 'angular2/angular2';


// Annotation section
@Component({
  selector: 'app'
})


@View({
  template: '<h1>Hello : {{ name }}</h1>'
})

// Component controller
class App {
  name: string;
  constructor() {
    this.name = 'Manu';
  }
}

bootstrap(App);
