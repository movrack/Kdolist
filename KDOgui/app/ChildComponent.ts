import {Component, View, bootstrap} from 'angular2/angular2';

//TypeScript
@Component({
    selector: 'child'
})
@View({
    template: `
        <p> {{ message }} </p>
      `
})
class ChildComponent {
    message: string;
    constructor() {
        this.message = "I'm the child";
    }
}
bootstrap(ChildComponent);