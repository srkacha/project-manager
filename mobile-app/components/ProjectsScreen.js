import React from 'react';
import { StyleSheet, Text, View, Button, Image, TextInput } from 'react-native';
import LoginScreen from './LoginScreen';

export default class ProjectsScreen extends React.Component {

    constructor(props){
      super(props);
      this.state = {
        user: this.props.navigation.getParam('user')
      };
    }

    static navigationOptions = ({ navigation }) =>{
      return {
        title: 'Projectory',
        headerRight: (
          <View style = {{paddingRight: 20}}><Button title="Logout" color="darkblue"
            onPress={() => navigation.popToTop()}
          /></View>),
          headerLeft: null
      }
  };

    componentWillMount(){

    }

    componentDidMount(){
    }

    render(){
      return (
        <View>
          <Text>Hello there</Text>
        </View>
      )
    }
  }