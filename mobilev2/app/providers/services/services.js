import {IonicApp, Platform, Alert} from 'ionic-angular';
import {Injectable} from 'angular2/core';
import {Http} from 'angular2/http';
import 'rxjs/add/operator/map';

/*
  Generated class for the Services provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular 2 DI.
*/
@Injectable()
export class Services {
  static get parameters(){
    return [[Http], [IonicApp], [Platform]]
  }  

  constructor(http, app, platform) {
    this.http = http;
    this.data = null;

    this.platform = platform;

    this.baseUrl = 'http://www.appdemo.co.in/myvegs/'
    this.key = 'ca966ceb77c7ef7';

    this.nav = app.getActiveNav();

    /*this.platform.ready().then(() => {
        var networkState = navigator.connection.type;

        if(networkState == connection.NONE) {
            var alert = Alert.create({
                title: 'ERROR!',
                message: 'No network connection',
                buttons: ['Ok']
            });
            this.nav.present(alert);
        } else {
            return true;
        }
    });*/
  }

    completeOrder(user_id, cart) {
        var url = this.baseUrl+'product/0.1/complete-order';
        var post_data = JSON.stringify({key: this.key, user: user_id, cart: cart});

        return this.http.post(url, post_data).map(res => res.json());
    }

    loadAreas() {

        var url = this.baseUrl+'master/0.1/get-areas';
        var post_data = JSON.stringify({key: this.key});

        return this.http.post(url, post_data).map(res => res.json());
    }

    addAddress(user_id, area_id, posted_data) {
        var url = this.baseUrl+'account/0.1/add-address';
        var post_data = JSON.stringify({key: this.key, user: user_id, area: area_id, data: posted_data});

        return this.http.post(url, post_data).map(res => res.json());
    }

    loadAddresses(user_id) {
        var url = this.baseUrl+'account/0.1/get-addresses';
        var post_data = JSON.stringify({key: this.key, user: user_id});

        return this.http.post(url, post_data).map(res => res.json());
    }

    updateCart(cart_id, posted_data) {
        var url = this.baseUrl+'product/0.1/update-cart';
        var post_data = JSON.stringify({key: this.key, cart: cart_id, data: posted_data});

        return this.http.post(url, post_data).map(res => res.json());
    }

    checkoutCart(cart_id, posted_data) {
        var url = this.baseUrl+'product/0.1/checkout';
        var post_data = JSON.stringify({key: this.key, cart: cart_id, data: posted_data});

        return this.http.post(url, post_data).map(res => res.json());
    }

    loginToApp(posted_data) {
        var url = this.baseUrl+'account/0.1/app-login';
        var post_data = JSON.stringify({key: this.key, data: posted_data});

        return this.http.post(url, post_data).map(res => res.json());
    }

    signupInApp(posted_data) {
        var url = this.baseUrl+'account/0.1/app-signup';
        var post_data = JSON.stringify({key: this.key, data: posted_data});

        return this.http.post(url, post_data).map(res => res.json());
    }

    loadHome(user_id) {
        var url = this.baseUrl+'product/0.1/get-home-contents';
        var post_data = JSON.stringify({key: this.key, user: user_id});

        return this.http.post(url, post_data).map(res => res.json());
    }

    loadProducts(category) {
        var url = this.baseUrl+'product/0.1/get-products';
        var post_data = JSON.stringify({key: this.key, category: category.id});

        return this.http.post(url, post_data).map(res => res.json());
    }

    loadCart(cart_id) {
        var url = this.baseUrl+'product/0.1/get-cart-products';
        var post_data = JSON.stringify({key: this.key, cart: cart_id});

        return this.http.post(url, post_data).map(res => res.json());
    }

    addToCart(item_id, user_id, cart, quantity_id) {
        var url = this.baseUrl+'product/0.1/add-to-cart';
        var post_data = JSON.stringify({key: this.key, user: user_id, item: item_id, cart: cart, quantity: quantity_id});

        return this.http.post(url, post_data).map(res => res.json());
    }
}

