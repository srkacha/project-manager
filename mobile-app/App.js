import React from 'react';
import { StyleSheet, Text, View, Button, Image, TextInput } from 'react-native';
import { createStackNavigator, createAppContainer } from 'react-navigation';

//Code representing the screens that will be rendered

class LoginScreen extends React.Component {
  static navigationOptions = {
  };
  render() {
    return (
    <View style={{paddingTop:20, alignItems: 'center'}}>
      <Text style = {styles.loginText}>Welcome to Projectory</Text>  
      <Image style = {styles.loginImage} source = {require('./assets/project.png')}></Image>
      <TextInput placeholder = 'Username' style = {styles.loginInput}></TextInput>
      <TextInput placeholder = 'Password' secureTextEntry = {true} style = {styles.loginInput}></TextInput>
      <Button color = 'darkblue' style = {styles.loginButton} title = 'Login'/>
    </View>
    );
  }
}

//Code responsible for navigation

const MainNavigator = createStackNavigator(
  {
    Login: {screen: LoginScreen},
  },
  {
    initialRouteName: "Login",
    defaultNavigationOptions: {
      headerStyle: {
        backgroundColor: 'white',
      },
      headerTintColor: 'black',
      headerTitleStyle: {
        fontWeight: 'bold',
      },
    },
  }
);

//Exporting the main app object

const App = createAppContainer(MainNavigator);
export default App;

//Styles for the screens

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
