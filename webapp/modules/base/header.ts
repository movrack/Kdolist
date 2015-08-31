/// <reference path="typings/angular2/angular2.d.ts" />
import {Component, View, bootstrap} from 'angular2/angular2';

// Annotation section
@Component({ selector: 'header' })
@View({ templateUrl: 'views/header.html' })

// Component controller
class Header {
}

bootstrap(Header);