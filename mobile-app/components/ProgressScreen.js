import React from 'react';
import { StyleSheet, Text, View, Button, Image, TextInput, Alert } from 'react-native';

const progressUpdateURL = 'https://pisio.etfbl.net/~srdjanj/project-manager/api/activities/add-progress-for-activity';

export default class ProgressScreen extends React.Component{
    constructor(props){
        super(props);
        this.state = {
          user: this.props.navigation.getParam('user'),
          activity: this.props.navigation.getParam('activity'),
          hoursWorked: '',
          comment: ''
        };

        this.handleInputChangeComment = this.handleInputChangeComment.bind(this);
        this.handleInputChangeHoursWorked = this.handleInputChangeHoursWorked.bind(this);
        this.validateInput = this.validateInput.bind(this);
        this.updateProgress = this.updateProgress.bind(this);
      }
  
      static navigationOptions = ({ navigation }) =>{
        return {
          title: 'Update progress',
          headerRight: (
            <View style = {{paddingRight: 20}}><Button title="Logout" color="#f76c6c"
              onPress={() => navigation.popToTop()}
            /></View>)
        }
      };
  
    componentWillMount(){

    }

    componentDidMount(){
    }

    handleInputChangeHoursWorked(event = {}){
        const value = event;
        this.setState({hoursWorked: value});
    }

    handleInputChangeComment(event = {}){
        const value = event;
        this.setState({comment: value});
    }

    updateProgress(){
      if(this.validateInput()){
        let formData = new FormData();
        formData.append('user_id', this.state.user.id);
        formData.append('auth_key', this.state.user.auth_key);
        formData.append('activity_id', this.state.activity.id);
        formData.append('hours_done', this.state.hoursWorked);
        formData.append('comment', this.state.comment);
        fetch(progressUpdateURL, {
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
              Alert.alert('Success', 'Activity progress updated successfully.');
              this.setState({
                hoursWorked: '',
                comment: '' 
              })
        }).catch((error) => Alert.alert('Update failed', 'There was a problem updating progress data.'));

      }else{
        Alert.alert('Data format problem', 'Hours worked has to be a positive integer.')
      }
    }

    validateInput(){
      try{
        let hours = this.state.hoursWorked;
        if(hours > 0) return true;
        else return false;
      }catch(error){
        return false;
      }
    }

    render(){
    return (
        <View style = {styles.progressView}>
          <Image style = {styles.progressImage} source = {require('../assets/list.png')}></Image>
          <Text style = {styles.progressLabel}>{'Hours worked'}</Text>
          <TextInput value = {this.state.hoursWorked} onChangeText = {this.handleInputChangeHoursWorked} keyboardType = 'numeric' name = 'hours_worked' style = {styles.progressInput}></TextInput>
          <Text style = {styles.progressLabel}>{'Comment'}</Text>
          <TextInput value = {this.state.comment} onChangeText = {this.handleInputChangeComment} name = 'comment' style = {styles.progressInput} multiline = {true} numberOfLines = {3}></TextInput>
          <Button title = 'Update' color = '#f76c6c' onPress = {this.updateProgress}></Button>
        </View>
    )
    }
    
}

const styles = StyleSheet.create({
  progressView: {
    padding: 10,
    backgroundColor: '#a8d0e6',
    flex: 1,
    alignItems: 'center'
  },
  progressInput: {
    borderRadius: 10,
    backgroundColor: 'white',
    marginBottom: 25,
    width: 300,
    padding: 10
  },
  progressImage: {
    width: 200,
    height: 200,
    alignItems: 'center',
    marginTop: 25,
    marginBottom: 25
  },
  progressLabel: {
    marginBottom: 5,
    fontSize: 15
  }
})