package utsppk2018_15_8518;

public class GUIController {
    
    private RestProxy proxy;
    private MainFrame mf;
    
    public GUIController(MainFrame mf, RestProxy proxy) {
        this.mf = mf;
        this.proxy = proxy;
        generateBound();
        clearInputUI();
        clearAlertUI();
        fetchTable();
    }
    
    private void generateBound() {
        mf.getSimpanButton().addActionListener(al -> {
            clearAlertUI();
            submitUser();
            fetchTable();
        });
        
        mf.getFindButton().addActionListener(al -> {
            String query = mf.getSearchTextField().getText();
            System.out.println(query);
            clearAlertUI();
            if (query.length() == 0) {
                fetchTable();
            } else {
                fetchTableByQuery(query);
            }
        });
        
        mf.getRefreshButton().addActionListener(al -> {
            clearAlertUI();
            fetchTable();
        });
    }
    
    private void fetchTable() {
        try {
            mf.getOutputPane1().getTableModel().setUsers(proxy.getAllUsers());
            mf.getOutputPane1().getTableModel().fireTableDataChanged();
        } catch (Exception ex) {
            AlertPane.showException(mf, ex.toString());
            AlertPane.showException(mf, "Failed to get entire table : " + ex);
        }
    }
    
    private void fetchTableByQuery(String query) {
        try {
            mf.getOutputPane1().getTableModel().setUsers(proxy.getUsersByQuery(query));
            mf.getOutputPane1().getTableModel().fireTableDataChanged();
        } catch (Exception ex) {
            AlertPane.showException(mf, ex.toString());
            AlertPane.showException(mf, "Failed to get search table : " + ex);
        }
    }
    
    private void clearInputUI() {
        mf.getUsernameTextField().setText("");
        mf.getNamaTextField().setText("");
        mf.getPasswordField().setText("");
        mf.getKonfirmasiPasswordField().setText("");
        mf.getEmailTextField().setText("");
    }
    
    private void clearAlertUI() {
        mf.getUsernameAlert().setText("");
        mf.getNamaAlert().setText("");
        mf.getPasswordAlert().setText("");
        mf.getKonfirmasiPasswordAlert().setText("");
        mf.getEmailAlert().setText("");
    }
    
    private void submitUser() {
        User user = new User();
        int error = 0;
        
        try {
            user.setUsername(mf.getUsernameTextField().getText());
        } catch (Exception ex) {
            mf.getUsernameAlert().setText(ex.getMessage());
            error++;
        }
        
        try {
            user.setNamaLengkap(mf.getNamaTextField().getText());
        } catch (Exception ex) {
            mf.getNamaAlert().setText(ex.getMessage());
            error++;
        }
        
        try {
            String password = new String(mf.getPasswordField().getPassword());
            String passCon = new String(mf.getKonfirmasiPasswordField().getPassword());
            if (!password.equals(passCon)) {
                mf.getKonfirmasiPasswordAlert().setText("konfirmasi password tidak cocok");
            }
            
            user.setPassword(password);
        } catch (Exception ex) {
            mf.getPasswordAlert().setText(ex.getMessage());
            error++;
        }
        
        try {
            user.setEmail(mf.getEmailTextField().getText());
        } catch (Exception ex) {
            mf.getEmailAlert().setText(ex.getMessage());
            error++;
        }
        
        if (error > 0) {
            AlertPane.showException(mf, "Silahkan cek input! Terdapat " + error + " error!");
        } else {
            try {
                if (mf.getEditCheckBox().isSelected()) {
                    int result = proxy.putUser(user);
                    switch (result) {
                        case 200:
                            AlertPane.showInformation(mf, "Berhasil edit/buat user");
                            break;
                        default:
                            AlertPane.showException(mf, "Ada kesalahan server (" + result + ")");
                            break;
                    }
                } else {
                    int result = proxy.addUser(user);
                    switch (result) {
                        case 201:
                            AlertPane.showInformation(mf, "Berhasil mengupload user");
                            break;
                        case 409:
                            AlertPane.showException(mf, "Username telah ada (" + result + ")");
                            break;
                        default:
                            AlertPane.showException(mf, "Ada kesalahan server (" + result + ")");
                            break;
                    }
                }
                
            } catch (Exception ex) {
                AlertPane.showException(mf, "Gagal mengupload user : " + ex.getMessage());
            }
        }
    }
}
