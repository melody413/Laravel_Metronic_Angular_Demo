import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditCenterComponent } from './edit-center.component';

describe('EditCenterComponent', () => {
  let component: EditCenterComponent;
  let fixture: ComponentFixture<EditCenterComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [EditCenterComponent]
    });
    fixture = TestBed.createComponent(EditCenterComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
