import {Storage, SqlStorage} from 'ionic-angular';
import {Injectable} from 'angular2/core';

/*
  Generated class for the Services provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular 2 DI.
*/
@Injectable()
export class SQLite {
  static get parameters(){
    return []
  }  

  constructor() {
    let options = {
        name: 'mvfdb',              // the name of the database
        backupFlag: SqlStorage.BACKUP_LOCAL, // where to store the file
        existingDatabase: false              // load this as an existing database
    };

    this.storage = new Storage(SqlStorage, options);

    //this.clearStorage();
    this.createStorage();
  }


  clearStorage() {
    let drop_user = 'DROP TABLE IF EXISTS user_details';
    this.storage.query(drop_user);
  }

  updateUser(data) {

      let cart = 'DROP TABLE IF EXISTS cart';
      this.storage.query(cart);

      let user = 'CREATE TABLE IF NOT EXISTS user_details (id INTEGER PRIMARY KEY, strName VARCHAR(50) NOT NULL, strImageName VARCHAR(100), strEmail VARCHAR(100) NOT NULL)';
      this.storage.query(user);

      let sql = "insert into user_details(id, strName, strImageName, strEmail) values (?, ?, ?, ?)"
      return this.storage.query(sql, [data.id, data.strFirstName+' '+data.strLastName, data.strImageName, data.strEmail])
  }

  createStorage() {
    let cart = 'CREATE TABLE IF NOT EXISTS cart (id INTEGER PRIMARY KEY, idAddress INTEGER NULL, strSlot VARCHAR(50) NULL, strPayment VARCHAR(5) NULL, tinStatus TINYINT(1) DEFAULT "0")';
    this.storage.query(cart);

    let area = 'CREATE TABLE IF NOT EXISTS areas (id INTEGER PRIMARY KEY, strArea VARCHAR(50) NOT NULL, strCity VARCHAR(50) NOT NULL, strState VARCHAR(50) NOT NULL, intPinCode INTEGER(6) NOT NULL, tinStatus TINYINT(1) DEFAULT "1")';
    this.storage.query(area);
  }

  insertCart(data) {
      let sql = "insert into cart(id) values (?)";
      return this.storage.query(sql, [data.cart]);
  }

  updateCart(field, value, id) {
      let sql = "update cart set "+field+" = ? where id = ?";
      console.log(sql + ' - ' + value + ' - ' + id);
      return this.storage.query(sql, [value, id]);
  }

  setKey(key, value) {
      this.storage.set(key, value);
  }

  getKey(key) {
      return this.storage.get(key);
  }

  removeKey(key) {
      return this.storage.remove(key);
  }

  getCart(id) {
      let sql = "select * from cart where id = ? and tinStatus = ?";
      return this.storage.query(sql, [id, 0]);
  }

  getUser() {
      let sql = "select * from user_details limit 1";
      console.log(sql);
      return this.storage.query(sql);
  }
}