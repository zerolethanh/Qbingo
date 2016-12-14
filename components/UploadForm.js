/**
 * Created by ZE on 2016/12/14.
 */

class UploadForm extends React.Component {
    constructor(props) {
        super(props)
        this.state = {"message": ''}
    }

    render() {
        return (
            <form action="/upload">
                <div>名前:<input type="text" name="name"/></div>
                <div>性別:
                    <input type="radio"/>男
                    <input type="radio"/>女
                </div>
                <div>
                    お祝いメッセージ
                    <textarea name="message" id="message" cols="30" rows="10"
                              value={this.state.message} />
                </div>
                <div>
                    <button>写真選択</button>
                </div>
                <div>
                    <button type="submit">OK</button>
                </div>
            </form>
        );
    }
}