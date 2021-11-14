import React from 'react';
import { FilePond, registerPlugin } from 'react-filepond';
import 'filepond/dist/filepond.min.css';
import {toastr} from 'react-redux-toastr'
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';

registerPlugin(FilePondPluginFileValidateSize);
registerPlugin(FilePondPluginFileValidateType);

class uploadFile extends React.Component {
  constructor(props) {
      super(props);

      this.state = {
          // skip: true,
          files: []
      };
  }
  
  handleInit() {
      this.setState({files:[]})
  }

  onLoaded = response => {
    console.log("onLoaded", response); // it print the id returned by the server
  };

  render(){
    return(
      <div className="upload-file" key={this.props.key}>
        <div className="hero">
          <p>{this.props.title}</p>
          <i className="icon-cloud-upload"></i>
        </div>
        <FilePond ref={ref => this.pond = ref}
                files={this.state.files}
                allowMultiple={true}
                labelIdle={"Click here to upload your files"}
                allowFileTypeValidation={true}
                acceptedFileTypes={['image/png', 'image/jpeg', 'application/pdf']}
                allowFileSizeValidation	={true}
                maxFileSize={'2MB'}
                chunkUploads={false}
                oninit={() => this.handleInit() }
                server={{
                  url: this.props.process,
                  process: {
                    onerror: (response) =>{
                      console.log("onErrorFile", response);
                    },
                    onload: (response) => { 
                      console.log("onProcessFile", response); // prints file ok
                      this.props.uploadFile(this.pond.props)
                    },
                  }
                }}
                onupdatefiles={(fileItems) => {
                    // Set current file objects to this.state
                    console.log(fileItems)
                    this.setState({
                        // skip: false,
                        files: fileItems.map(fileItem => fileItem.file)
                    });
                }}>
      </FilePond>
      {this.props.warning}
      {this.props.skip === true?
        <div className="warning">
          <button onClick={this.props.skipped.bind(this)}>Skip</button>
        </div>
      :null}
      </div>
      )}
}
export default uploadFile