import {Page, NavController} from 'ionic-angular';
import {MainPage} from '../main/main';

/*
 Generated class for the IntroPage page.

 See http://ionicframework.com/docs/v2/components/#navigation for more info on
 Ionic pages and navigation.
 */
@Page({
    templateUrl: 'build/pages/intro/intro.html',
})
export class IntroPage {

    static get parameters() {
        return [[NavController]];
    }

    constructor(nav) {
        this.nav = nav;
    }

    goToHome() {
        this.nav.setRoot(MainPage);
    }
}
