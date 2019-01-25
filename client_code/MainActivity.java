package football.thekingsacademy.net.kingsacademyfootball;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.google.firebase.iid.FirebaseInstanceId;

import java.util.HashMap;
import java.util.Map;

import android.os.Bundle;
import android.view.View;

public class MainActivity extends AppCompatActivity {
    Button button;
    String app_server_url = "http://ip_addr/fcmtest/fcm_insert.php";
    //String app_server_url = "http://ip_addr/fcmtest/fcm_insert.php";
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
/*
        sleep(1000);
        Intent team_schedule_activity = new Intent(this, team_schedule.class );
        startActivity(team_schedule_activity);
        finish();
        */

        //super.onCreate(savedInstanceState);
        //setContentView(R.layout.activity_main);
        //button = (Button)findViewById(R.id.button);
        /*
        //Onclick listener
        button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
            */
        SharedPreferences sharedPreferences = getApplicationContext().getSharedPreferences(getString(R.string.FCM_PREF), Context.MODE_PRIVATE);
        //Below line is the token
        //String ff = FirebaseInstanceId.getInstance().getToken();
        //final String token = sharedPreferences.getString(getString(R.string.FCM_TOKEN),"");
        //final String token = sharedPreferences.getString(getString(R.string.FCM_TOKEN),ff);
        final String token = "";
        StringRequest stringRequest = new StringRequest(Request.Method.POST, app_server_url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {

            }
        })
        {
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String,String> params = new HashMap<String, String>();
                params.put("fcm_token",token);
                return params;
            }
        };
       // MySingleton.getmInstance(MainActivity.this).addToRequestque(stringRequest);

            /*
            //Onclick listener close
            }
        });

        */


    }

    public void sendMessage(View view)
    {
        Intent startNewActivity = new Intent(this, DisplayMessage .class);
        startActivity(startNewActivity);
    }
    public void gotonotifications(View view)
    {
        Intent notifications_activity = new Intent(this, Notifications.class );
        startActivity(notifications_activity);
    }
    public void gotoevents (View view)
    {
        Intent events_activity = new Intent(this, events.class );
        startActivity(events_activity);
    }
    public void gotoscore (View view)
    {
        Intent score_activity = new Intent(this, score.class );
        startActivity(score_activity);
    }
    public void goto_teamschedule (View view)
    {
        Intent team_schedule_activity = new Intent(this, team_schedule.class );
        startActivity(team_schedule_activity);
    }
    public void gotofundraiser (View view)
    {

    }
    public void gotoadmissions (View view)
    {

    }
}
