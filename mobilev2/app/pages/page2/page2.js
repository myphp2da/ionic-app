import {Page, NavController} from 'ionic-angular';


@Page({
    templateUrl: 'build/pages/page2/page2.html'
})
export class Page2 {

    static get parameters() {
        return [[NavController]];
    }

    constructor(nav) {
        this.nav = nav;
    }
}
