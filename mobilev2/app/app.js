import {App, Platform, Storage, SqlStorage, IonicApp, MenuController} from 'ionic-angular';
import {StatusBar} from 'ionic-native';
import {MainPage} from './pages/main/main';
import {HomePage} from './pages/home/home';
import {IntroPage} from './pages/intro/intro';
import {AccountPage} from './pages/account/account';
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

      this.initializeApp();

      this.localStorage();

      this.pages = [
          { title: 'Home', component: HomePage, icon: 'home' },   
          { title: 'My Account', component: AccountPage, icon: 'user' },
          { title: 'Main Page', component: MainPage, icon: 'page' }
      ];

      this.account_pages = [
          { title: 'My Account', component: AccountPage, icon: 'user' },
          { title: 'Manage Delivery Addresses', component: MainPage, icon: 'page' },
          { title: 'My Orders', component: MainPage, icon: 'page' }
      ];
  }

    localStorage() {

        this.sqlite.getKey('IntroShown').then((result) => {
            if(result) {
                this.sqlite.getKey('UserId').then((result) => {
                    if(result) {
                        this.rootPage = HomePage;
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
        nav.setRoot(page.component);
    }
}
