import {Page, NavController} from 'ionic-angular';

/*
  Generated class for the OrderDetailsPage page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Page({
  templateUrl: 'build/pages/order-details/order-details.html',
})
export class OrderDetailsPage {
  static get parameters() {
    return [[NavController]];
  }

  constructor(nav) {
    this.nav = nav;
  }
}
