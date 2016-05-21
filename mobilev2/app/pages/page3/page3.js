import {Page, NavController} from 'ionic-angular';


@Page({
    templateUrl: 'build/pages/page3/page3.html'
})
export class Page3 {

    static get parameters() {
        return [[NavController]];
    }

    constructor(nav) {
        this.nav = nav;
    }
}
