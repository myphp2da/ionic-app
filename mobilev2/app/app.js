import {App, Platform, Storage, SqlStorage, IonicApp, MenuController} from 'ionic-angular';
import {StatusBar, Device} from 'ionic-native';
import {MainPage} from './pages/main/main';
import {HomePage} from './pages/home/home';
import {IntroPage} from './pages/intro/intro';
import {LoginPage} from './pages/login/login';
import {SignupPage} from './pages/signup/signup';
import {AccountPage} from './pages/account/account';
import {DeliveryPage} from './pages/delivery/delivery';
import {OrdersPage} from './pages/orders/orders';
import {ConfirmPage} from './pages/confirm/confirm';
import {Services} from './providers/services/services';
import {SQLite} from './providers/sqlite/sqlite';
import {LoadingModal} from './components/loading-modal/loading-modal';

@App({
  templateUrl: 'build/app.html',
  providers: [Services, SQLite],
  directives: [LoadingModal],
  config: { mode: 'md' } // http://ionicframework.com/docs/v2/api/config/Config/
})
export class MyApp {
  static get parameters() {
    return [[Platform], [IonicApp], [MenuController], [SQLite]];
  }

  constructor(platform, app, menu, sqlite) {

      this.sqlite = sqlite;

      this.platform = platform;
      this.menu = menu;
      this.app = app;

      this.shownGroup = null;

      this.initializeApp();

      this.localStorage();

      this.pages = [
          { title: 'Home', component: HomePage, type: 'root' },
      ];

      this.signup_pages = [
          { title: 'Login', component: LoginPage, type: 'redirect' },   
          { title: 'Sign Up', component: SignupPage, type: 'redirect' },
      ];

      this.account_pages = [
          { title: 'My Account', component: AccountPage, type: 'redirect' },
          { title: 'My Orders', component: OrdersPage, type: 'redirect' }
      ];

      this.user_image = 'images/profile.jpg';
      this.sqlite.getUser().then((result) => {
          this.user = result.res.rows.item(0);
          if(this.user.strImageName != null) {
              this.user_image = this.user.strImageName;
          }
      }, (error) => {
          console.log(error);
      });

      this.categories = [];
      this.sqlite.getCategories().then((result) => {
          if(result) {
              if(result.res.rows.length > 0) {
                for(var i = 0; i < result.res.rows.length; i++) {
                    var row = result.res.rows.item(i);
                    var category_id = row.id;

                    if(row.idParent != 0) {
                        this.categories.forEach(function(cat) {
                            if(cat.id == row.idParent) {
                                cat.sub_categories.push({
                                    id: row.id, 
                                    name: row.strCategory
                                });
                            }
                        })
                    } else {
                        this.categories.push({
                            id: row.id, 
                            name: row.strCategory,
                            sub_categories: []
                        });
                    }
                }

                console.log(this.categories);
              }
          }
      });
  }

  isGroupShown(group) {
      //console.log(group.sub_categories);
    return (this.shownGroup == group.id);
  }

  logoutApp() {
      this.menu.close();
      this.sqlite.removeKey('UserId');
      let nav = this.app.getComponent('nav');
      nav.setRoot(MainPage);
  }

  toggleGroup(group) {
      //console.log(this.shownGroup);
    if (this.isGroupShown(group)) {
      this.shownGroup = null;
    } else {
      this.shownGroup = group.id;
    }
  }

    localStorage() {

        this.sqlite.getKey('IntroShown').then((result) => {
            if(result) {
                this.sqlite.getKey('UserId').then((result) => {
                    if(result) {
                        this.rootPage = AccountPage;
                    } else {
                        this.rootPage = MainPage;
                    }
                });
            } else {
                this.sqlite.setKey('IntroShown', true);
                this.rootPage = IntroPage;
            }
        });
    }

    initializeApp() {
        this.platform.ready().then(() => {
            
        });
    }

    // this function will come handy in template
    // It handles the changing of pages via the sidemenu
    // Without this function, all the tantrum we threw above are useless
    openPage(page) {
        this.menu.close()
        let nav = this.app.getComponent('nav');
        if(page.type == 'root') {
            nav.setRoot(page.component);
        } else {
            nav.push(page.component);
        }
    }
}
