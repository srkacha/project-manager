import React from 'react';
import { StyleSheet, Text, View, Button, Image, TextInput } from 'react-native';

export default class LoginScreen extends React.Component {

    constructor(props){
      super(props);
  
      //binding the functions to the object
      this.handleInputChange = this.handleInputChange.bind(this);
  
      this.state = {
        username: '',
        password: ''
      };
    }
  
    static navigationOptions = {
    };
  
    handleInputChange(event = {}){
      const name = event.target && event.target.name;
      const value = event.target && event.target.value;
  
      //setting the state values for username and password
      if(name == 'username'){
          this.setState({username: value});
      }else if(name == 'password'){
        this.setState({password: password});
      }
    }
  
    login(){
      alert('cao');
    }
  
    render() {
      return (
      <View style={{paddingTop:20, alignItems: 'center'}}>
        <Text style = {styles.loginText}>Welcome to Projectory</Text>  
        <Image style = {styles.loginImage} source = {require('../assets/project.png')}></Image>
        <TextInput name = 'username' onChangeText = {this.handleInputChange} placeholder = 'Username' style = {styles.loginInput}></TextInput>
        <TextInput name = 'password' onChangeText = {this.handleInputChange} placeholder = 'Password' secureTextEntry = {true} style = {styles.loginInput}></TextInput>
        <Button onPress = {this.login} color = 'darkblue' style = {styles.loginButton} title = 'Login'/>
      </View>
      );
    }
  }

  const styles = StyleSheet.create({
    loginImage: {
      height: 250,
      width: 250, 
      marginBottom: 25
    },
    loginInput: {
      borderBottomColor: 'gray', 
      borderBottomWidth: 1, 
      marginBottom:25,
      width: 250
    },
    loginText: {
      fontSize:40,
      textAlign: 'center',
      fontWeight: 'bold',
      marginBottom:25
    },
    loginButton: {
      width: 250
    }
  });