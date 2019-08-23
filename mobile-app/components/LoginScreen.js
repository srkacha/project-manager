import React from 'react';
import { StyleSheet, Text, View, Button, Image, TextInput, Alert } from 'react-native';

const loginURL = 'https://pisio.etfbl.net/~srdjanj/project-manager/api/users/login';

export default class LoginScreen extends React.Component {

    constructor(props){
      super(props);
  
      //binding the functions to the object
      this.handleInputChangeUsername = this.handleInputChangeUsername.bind(this);
      this.handleInputChangePassword = this.handleInputChangePassword.bind(this);
      this.login = this.login.bind(this);
    }

    state = {
        username: '',
        password: ''
      };
  
    static navigationOptions = {
    };
  
    handleInputChangeUsername(event = {}){
        const value = event;
        this.setState({username: value});
    }

    handleInputChangePassword(event = {}){
        const value = event;
        this.setState({password: value});
    }
  
    login(){
        let formData = new FormData();
        formData.append('username', this.state.username);
        formData.append('password', this.state.password);

        fetch(loginURL, {
          method: 'POST',
          headers: {
            Accept: 'application/json',
            'Content-Type': 'multipart/form-data',
          },
          body: formData
      }).then((response) => {
            if(response.status === 200){
                 return response.json();
            }else{
                return Promise.reject();
            }
      }).then(responseJson => {
            this.props.navigation.navigate('Projects', {user: responseJson});
      }).catch((error) => Alert.alert('Login failed','Username or password is incorrect.'));
    }
  
    render() {
      return (
      <View style={{paddingTop:20, alignItems: 'center', backgroundColor: '#a8d0e6', flex: 1}}>
        <Text style = {styles.loginText}>Welcome to Projectory</Text>  
        <Image style = {styles.loginImage} source = {require('../assets/project.png')}></Image>
        <TextInput name = 'username' onChangeText = {this.handleInputChangeUsername} placeholderTextColor = 'black' placeholder = 'Username' style = {styles.loginInput}></TextInput>
        <TextInput name = 'password' onChangeText = {this.handleInputChangePassword} placeholderTextColor = 'black' placeholder = 'Password' secureTextEntry = {true} style = {styles.loginInput}></TextInput>
        <Button onPress = {this.login} color = '#f76c6c' style = {styles.loginButton} title = 'Login'/>
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
      width: 250,
      backgroundColor: 'white',
      paddingLeft: 5,
      height: 40,
      borderRadius: 5
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