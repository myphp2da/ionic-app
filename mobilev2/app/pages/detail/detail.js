import {Page, NavController, NavParams} from 'ionic-angular';
import {Services} from '../../providers/services/services';

/*
  Generated class for the DetailPage page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Page({
  templateUrl: 'build/pages/detail/detail.html',
})
export class DetailPage {
  static get parameters() {
    return [[Services], [NavController], [NavParams]];
  }

  constructor(service, nav, navParams) {
    this.nav = nav;
    
    this.service = service;
    
    this.content = navParams.get('content');
  }
}
