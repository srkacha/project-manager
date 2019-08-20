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
                Alert.alert('Login failed', 'Username or password is incorrect.');
            }
      }).then(responseJson => {
            this.props.navigation.navigate('Projects', {user: responseJson});
      }).catch((error) => alert('There was an error with the request.'));
    }
  
    render() {
      return (
      <View style={{paddingTop:20, alignItems: 'center'}}>
        <Text style = {styles.loginText}>Welcome to Projectory</Text>  
        <Image style = {styles.loginImage} source = {require('../assets/project.png')}></Image>
        <TextInput name = 'username' onChangeText = {this.handleInputChangeUsername} placeholder = 'Username' style = {styles.loginInput}></TextInput>
        <TextInput name = 'password' onChangeText = {this.handleInputChangePassword} placeholder = 'Password' secureTextEntry = {true} style = {styles.loginInput}></TextInput>
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