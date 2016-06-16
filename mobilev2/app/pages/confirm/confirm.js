import {Page, NavController} from 'ionic-angular';

/*
  Generated class for the ConfirmPage page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Page({
  templateUrl: 'build/pages/confirm/confirm.html',
})
export class ConfirmPage {
  static get parameters() {
    return [[NavController]];
  }

  constructor(nav) {
    this.nav = nav;
  }
}
